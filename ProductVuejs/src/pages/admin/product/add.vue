<template>
  <form action="" method="post" @submit.prevent="addProduct">
    <div class="container-fluid">
      <div class="mb-3">
        <label for="formGroupExampleInput" class="form-label">Tên sản phẩm</label>
        <input
          type="text"
          class="form-control"
          id="formGroupExampleInput"
          name="title"
          v-model="product.product_name"
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
        <label for="formGroupExampleInput" class="form-label">Giá sản phẩm</label>
        <input
          type="number"
          class="form-control"
          id="formGroupExampleInput"
          name="title"
          v-model="product.gia_ban"
        />
      </div>
      <div class="mb-3">
        <label for="formGroupExampleInput" class="form-label">Mô tả sản phẩm</label>
        <input
          type="text"
          class="form-control"
          id="formGroupExampleInput"
          name="title"
          v-model="product.mo_ta"
        />
      </div>
      <button type="submit" class="btn btn-primary">Thêm Product</button>
    </div>
  </form>
</template>

<script>
import { defineComponent, ref } from "vue";
import { useRouter } from "vue-router";
import { message } from "ant-design-vue";
import axios from "axios";

export default defineComponent({
  setup() {
    const router = useRouter();
    const product = ref({
      product_name: "",
      product_image: null,
      gia_ban: "",
      mo_ta: "",
      ngay_Cap_nhat: "",
    });

    const errors = ref({});
    const addProduct = () => {
      const formData = new FormData();
      formData.append("product_name", product.value.product_name);
      formData.append("product_image", product.value.product_image);
      formData.append("gia_ban", product.value.gia_ban);
      formData.append("mo_ta", product.value.mo_ta);
      formData.append("ngay_Cap_nhat", product.value.ngay_Cap_nhat);

      axios
        .post("http://127.0.0.1:8000/api/v1/products/add", formData)
        .then((response) => {
          if (response) {
            message.success("Tạo mới thành công!");
            router.push({ name: "admin-posts" });
          }
        })
        .catch((error) => {
          errors.value = error.response.data.errors;
        });
    };

    const onFileChange = (event) => {
      const file = event.target.files[0];
      product.value.product_image = file; // Assign the selected image file to the product_image property
    };

    return {
      errors,
      product,
      addProduct,
      onFileChange,
    };
  },
});
</script>