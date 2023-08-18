<script lang="ts">
import { defineComponent } from "vue";
import { useRouter } from "vue-router";
</script>
<template>
    <aside>
        <h1 class="aside__title">
            <router-link to="/dash_board">Gourmet Log</router-link>
        </h1>
        <h2 class="aside__sub-title">MENU</h2>
        <nav class="aside__nav">
            <ui class="aside__list">
                <li class="aside__list-itme">
                    <router-link to="/list">お店リスト</router-link>
                </li>
                <li class="aside__list-itme" @click="goShopRegisterEdit">
                    お店登録/編集
                </li>
                <li class="aside__list-itme" @click="goCategoryRegister">
                    カテゴリー管理
                </li>
            </ui>
        </nav>
        <div
            class="asiede__logout"
            type="button"
            style="cursor: pointer"
            @click="logout"
        >
            エックス
        </div>
    </aside>
</template>
<script lang="ts" setup>
import { authLogout, authGet } from "../../api/authApi";
import { onMounted, ref } from "vue";
import router from "../router";

const userId = ref<number>();
const goShopRegisterEdit = () => {
    router.push({
        name: "ShopRegisterEdit",
        query: {
            user_id: userId.value,
        },
    });
};
const goCategoryRegister = () => {
    router.push({
        name: "CategoryRegister",
        query: {
            user_id: userId.value,
        },
    });
};

const logout = async () => {
    await authLogout();
};
onMounted(async () => {
    await authGet()
        .then((res) => {
            userId.value = res.user.id;
        })
        .catch((err) => {
            router.push("/login");

            console.log(err.response);
        });
});
</script>

<style lang="scss" scoped>
aside {
    background-color: rgb(104, 205, 191);
    width: 250px;
    min-height: 980px;
    color: #fff;
    display: flex;
    align-items: center;
    font-size: 1.2rem;
    flex-direction: column;
    position: relative;
}
.aside__title {
    padding: 2rem 0;
}
.aside__sub-title {
    font-size: 1.2rem;
    border-top: 3px solid #fff;
    border-bottom: 3px solid #fff;
    width: 100%;
    text-align: center;
    line-height: 3rem;
}
.aside__nav {
    margin-top: 3rem;
    width: 100%;
}
.aside__list-itme {
    list-style-type: none;
    line-height: 3rem;
    width: 100%;
    text-align: center;
    cursor: pointer;

    &:hover {
        background-color: #fff;
        color: #000;
        width: 100%;
    }
}
.asiede__logout {
    position: absolute;
    bottom: 5rem;
}
</style>
