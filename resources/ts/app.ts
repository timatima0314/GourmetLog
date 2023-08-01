import "./bootstrap";
import router from "./router";

import { createApp, provide } from "vue";
import App from "./App.vue";
import { key, store } from "./store/store";
const app = createApp(App);
app.use(router);
app.use(store, key);
app.mount("#app");
