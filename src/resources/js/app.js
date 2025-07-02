import './bootstrap';

import { createApp } from "vue";
import router from './router/index.js'
import App from "./components/app.vue";

createApp(App).use(router).mount("#app");
