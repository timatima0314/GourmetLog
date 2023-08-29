import { createRouter, createWebHistory } from "vue-router";
const BASE_URL = "/";
import Home from "./page/Home.vue";
import Dashboard from "./page/Dashboard.vue";
import Login from "./page/Login.vue"
import SingUp from "./page/SingUp.vue";
import CategoryRegister from "./page/CategoryRegister.vue";
import CategoryEdit from "./page/CategoryEdit.vue";
import Confirmation from "./page/Confirmation.vue";
import Ditail from "./page/Ditail.vue";
import HotpepperDataDitail from "./page/HotpepperDataDitail.vue";
import List from "./page/List.vue";
import ShopRegisterEdit from "./page/ShopRegisterEdit.vue";
import NotFound from "./page/NotFound.vue";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
    },
    {
        path: '/dash_board',
        name: 'Dashboard',
        component: Dashboard,
    },

    {
        path: "/login",
        name: "Login",
        component: Login,
    },
    {
        path: "/singup",
        name: "SingUp",
        component: SingUp,
    },
    {
        path: "/category_register",
        name: "CategoryRegister",
        component: CategoryRegister
    },
    {
        path: "/category_edit",
        name: "CategoryEdit",
        component: CategoryEdit
    },
    {
        path: "/confirmation",
        name: "Confirmation",
        component: Confirmation
    },
    {
        path: "/ditail",
        name: "Ditail",
        component: Ditail
    },
    {
        path: "/hotpepper_data_ditail",
        name: "HotpepperDataDitail",
        component: HotpepperDataDitail
    },
    {
        path: "/list",
        name: "List",
        component: List
    },
    {
        path: "/shop_register_edit",
        name: "ShopRegisterEdit",
        component: ShopRegisterEdit
    },
    { path: '/:catchAll(.*)', component: NotFound }
];

const router = createRouter({
    history: createWebHistory(BASE_URL), // set BASE_URL
    routes,
});

export default router;
