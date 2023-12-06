<template>
    <br />
    <form action=""  @submit.prevent="getdangki()">
      <div class="container-fluid">
        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Name</label>
          <input
            type="text"
            class="form-control"
            id="formGroupExampleInput"
            v-model="name"
          />
        </div>
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
        <button type="submit" class="btn btn-primary">Đăng kí</button>
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
      const register = reactive({
      name: "",
      email: "",
      password: "",
    });
      const getdangki = () => {
          axios
            .post("http://127.0.0.1:8000/api/register", register)
            .then((response) => {
                if(response){
                    alert("đăng kí tài khoản thành công");
                    // router.push({ name: "frontend-login" });
                }
            })
            .catch((error) => {
              // Xử lý khi xảy ra lỗi
              console.log(error);
              message.error("Thông tin tài khoản hoặc mật khẩu chưa đúng!")
            });
      };
      return {
        // errors,
        ...toRefs(register),
        getdangki,
       
      };
    },
  });
  </script>
  