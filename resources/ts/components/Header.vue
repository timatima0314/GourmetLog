<template>
    <header>
        <div class="header__main">
            <div>
                <h1 class="header__title">
                    <router-link to="/">Gourmet Log</router-link>
                </h1>
            </div>
            <div class="header__auth">
                <div class="header__auth__item">
                    <router-link to="/login">ログイン</router-link>
                </div>
                <!-- <div v-else class="header__auth__item">
                    <div @click="logoutApp">ログアウト</div>
                </div> -->
                <div class="header__auth__item">
                    <router-link to="/singup">新規登録</router-link>
                </div>
            </div>
        </div>
    </header>
</template>
<script lang="ts" setup>
import { useRouter } from "vue-router";
</script>

<style lang="scss" scoped>
header {
    background-color: rgb(104, 205, 191);
    color: #fff;
    height: 100px;
}
.header__main {
    display: flex;
    height: 100%;
    justify-content: space-between;
    align-items: center;
    width: 1080px;
    margin: 0 auto;
}
.header__title {
    font-weight: normal;
}
.header__auth {
    display: flex;
    justify-content: space-between;
}
.header__auth__item {
    margin-right: 1rem;
    cursor: pointer;
}
</style>
