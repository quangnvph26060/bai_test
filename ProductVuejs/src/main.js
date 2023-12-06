import { createApp } from 'vue'
import { Button, message } from 'ant-design-vue';
import router from './router/index.js'

// import './style.css'
import axios from 'axios'
window.axios = axios;

import App from './App.vue'
import 'ant-design-vue/dist/reset.css';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.js'

const app = createApp(App);
app.use(router)
app.use(Button)
app.mount('#app')
app.config.globalProperties.$message = message;
