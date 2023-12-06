<template>
  <br />
  <form action=""  @submit.prevent="getlogin()">
    <div class="container-fluid">
      <div class="mb-3">
        <label for="formGroupExampleInput" class="form-label">Email</label>
        <input
          type="email"
          class="form-control"
          id="formGroupExampleInput"
          v-model="email"
        />
      </div>
      <div class="mb-3">
        <label for="formGroupExampleInput2" class="form-label">Password</label>
        <input
          type="password"
          class="form-control"
          id="formGroupExampleInput2"
          v-model="password"
        />
      </div>
      <button type="submit" class="btn btn-primary">Đăng nhập</button>
    </div>
  </form>
</template>
<script>
import { defineComponent, reactive, ref, toRefs } from "vue";
import axios from "axios";
import { message } from "ant-design-vue";
import { useRouter } from "vue-router";
import { useRoute } from "vue-router";
export default defineComponent({
  setup() {
    const router = useRouter();
    const route = useRoute();
    const login = reactive({
      email: "",
      password: "",
    });
    const getlogin = () => {
        axios
          .post("http://127.0.0.1:8000/api/login", login)
          .then((response) => {
            if (response) {
              // Lấy token và lưu vào sessionStorage
              const token = response.data.access_token;
              localStorage.setItem("token", token);

              // Chuyển hướng trang
              message.success("Đăng nhập thành công!");
              router.push({ name: "admin-posts" });
            } else {
              // Xử lý khi không nhận được response data
              console.log("Không nhận được dữ liệu từ phản hồi.");
              
              // router.push({ name: "frontend-login" });
            }
          })
          .catch((error) => {
            // Xử lý khi xảy ra lỗi
            console.log(error);
            error.value = error.response.data.errors;
            message.error("Thông tin tài khoản hoặc mật khẩu chưa đúng!")
          });
    };
    return {
      // errors,
      ...toRefs(login),
      getlogin,
     
    };
  },
});
</script>
