<template>
  <form action="" @submit.prevent="updateproduct">
    <div class="container-fluid">
      <div class="mb-3">
        <label for="formGroupExampleInput" class="form-label">Tên sản phẩm</label>
        <input
          type="text"
          class="form-control"
          id="formGroupExampleInput"
          name="title"
          v-model="product_name"
        />
      </div>
      <div class="mb-3">
        <label for="formGroupExampleInput2" class="form-label">Hình ảnh</label>
        <input
          type="file"
          class="form-control"
          ref="imageInput"
          @change="onFileChange"
        />
      </div>
      <div class="mb-3">
        <img :src="getProductImageUrl(product_image)" alt="" width="100">
      </div>
      <div class="mb-3">
        <label for="formGroupExampleInput" class="form-label">Giá sản phẩm</label>
        <input
          type="number"
          class="form-control"
          id="formGroupExampleInput"
          name="title"
          v-model="gia_ban"
        />
      </div>
      <div class="mb-3">
        <label for="formGroupExampleInput" class="form-label">Mô tả sản phẩm</label>
        <input
          type="text"
          class="form-control"
          id="formGroupExampleInput"
          name="title"
          v-model="mo_ta"
        />
      </div>
      <button type="submit" class="btn btn-primary">Update Product</button>
    </div>
  </form>
</template>

<script>
import { defineComponent, ref, reactive,toRefs } from "vue";
import { useRouter } from "vue-router";
import { useRoute } from "vue-router";
import { message } from "ant-design-vue";
import axios from "axios";

export default defineComponent({
  setup() {
    const router = useRouter();
    const route = useRoute();
    const product = reactive({
      product_name: "",
      product_image: null,
      gia_ban: "",
      mo_ta: "",
      ngay_Cap_nhat: "",
    });

    const errors = ref({});
    const editproduct = () => {
      axios
        .get(`http://127.0.0.1:8000/api/v1/products/edit/${route.params.id}`)
        .then((response) => {
          console.log(response);
          product.product_name = response.data.product_name;
          product.product_image = response.data.product_image;
          product.gia_ban = response.data.gia_ban;
          product.mo_ta = response.data.mo_ta;
          product.ngay_Cap_nhat = response.data.ngay_Cap_nhat;
        })
        .catch((error) => {
          console.log(error);
        });
    };
    editproduct();

    const updateproduct = () => {
      const formData = new FormData();
      formData.append("product_name", product.product_name);
      formData.append("product_image", product.product_image);
      formData.append("gia_ban", product.gia_ban);
      formData.append("mo_ta", product.mo_ta);
      formData.append("ngay_Cap_nhat", product.ngay_Cap_nhat);

      axios
        .post(`http://127.0.0.1:8000/api/v1/products/update/${route.params.id}`, formData, {
          headers: {
            'X-HTTP-Method-Override': 'PUT',
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          if (response) {
            message.success("Update thành công!");
            router.push({ name: "admin-posts" });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    };

    const onFileChange = (event) => {
      const file = event.target.files[0];
      product.product_image = file; // Gán file hình ảnh đã chọn vào thuộc tính product_image
    };

    const getProductImageUrl = (imageName) => {
      return `http://127.0.0.1:8000/image/${imageName}`;
    };

    return {
      errors,
      getProductImageUrl,
      ...toRefs(product),
      updateproduct,
      onFileChange,
    };
  },
});
</script>