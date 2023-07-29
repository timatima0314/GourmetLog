import "./bootstrap";
import router from "./router";

import { createApp, provide } from "vue";
import App from"./App.vue";

const app = createApp(App);
app.use(router);

app.mount("#app");
