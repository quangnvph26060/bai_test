<template>
  <div class="container-fluid">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Tên sản phẩm</th>
          <th scope="col">Image</th>
          <th scope="col">Giá bán</th>
          <th scope="col">Mô tả</th>
          <th scope="col">Ngày tạo</th>
          <th scope="col">Ngày cập nhật</th>
          <th scope="col">
            <router-link :to="{ name: 'admin-posts-add' }">
              <button type="button" class="btn btn-primary">Thêm sản phẩm</button>
            </router-link>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <th scope="row">{{ product.id }}</th>
          <td>{{ product.product_name }}</td>
          <td>
            <img :src="getProductImageUrl(product.product_image)" alt="" width="100">
          </td>
          <td>{{ displayPrice(product.gia_ban) }}</td>
          <td>{{ product.mo_ta }}</td>
          <td>{{ product.ngay_tao }}</td>
          <td>{{ product.ngay_Cap_nhat }}</td>
          <td>
            <router-link :to="{ name: 'admin-posts-edit', params: { id: product.id } }">
              <button type="button" class="btn btn-primary">Edit</button>
            </router-link>
            <router-link :to="{ name: 'admin-posts-delete', params: { id: product.id } }" @click="deleteProduct(product.id)">
              <button type="button" class="btn btn-danger">Xóa</button>
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { defineComponent, ref, onMounted, onUnmounted } from "vue";
import axios from "axios";
import { message } from "ant-design-vue";
import { useRouter } from "vue-router";
import { useRoute } from "vue-router";

export default defineComponent({
  setup() {
    const router = useRouter();
    const route = useRoute();
    const products = ref([]);
    const isLoggedIn = ref(false);

    const fetchProducts = () => {
      axios.get("http://127.0.0.1:8000/api/v1/products/list")
        .then((response) => {
          products.value = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    };

    onMounted(() => {
      const token = localStorage.getItem('token');
      if(token){
        isLoggedIn.value= true;
      }else{
        isLoggedIn.value= false;
      }
      fetchProducts();
    });

    const deleteProduct = (productId) => {
      if (confirm("Bạn có muốn xóa không ??")) {
        axios.delete(`http://127.0.0.1:8000/api/v1/products/delete/${productId}`)
          .then((response) => {
            if (response) {
              message.success("Xóa thành công!");
              fetchProducts();
              router.push({ name: "admin-posts" });
            }
          })
          .catch((error) => {
            console.log(error);
          });
      }
    };

    const getProductImageUrl = (image) => {
      return `http://127.0.0.1:8000/image/${image}`;
    };
    const displayPrice = (price) => {
      if (isLoggedIn.value==true) {
        return price;
      } else {
        return "Liên hệ";
      }
    };

    return {
      products,
      deleteProduct,
      getProductImageUrl,
      displayPrice,
    };
  },
});
</script>

<style scoped>
#modalkey {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
}
</style>