<template>
    <Header />
    <main>
        <div class="login">
            <div class="loginForm__box">
                <div class="loginForm__heading">ログイン</div>
                <form @submit.prevent>
                    <table class="loginForm__table">
                        <tr class="login__Form__tr">
                            <td class="loginForm__label">メールアドレス</td>
                            <td class="loginForm__input-wrap">
                                <input type="text" v-model="email" />
                            </td>
                        </tr>
                        <tr class="login__Form__tr error">
                            <td></td>
                            <td v-if="valiErrorMessage.email" class="err">
                                {{ valiErrorMessage.email[0] }}
                            </td>
                        </tr>

                        <tr class="login__Form__tr">
                            <td class="loginForm__label">パスワード</td>
                            <td class="loginForm__input-wrap">
                                <input type="password" v-model="password" />
                            </td>
                        </tr>
                        <tr class="login__Form__tr error">
                            <td></td>
                            <td v-if="valiErrorMessage.password" class="err">
                                {{ valiErrorMessage.password[0] }}
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td v-if="errorMessage" class="err">
                                {{ errorMessage }}
                            </td>
                        </tr>
                        <tr style="height: 1rem">
                            <td></td>
                            <td style="height: 3rem">
                                <input
                                    style="width: 1rem"
                                    type="checkbox"
                                    checked
                                /><label>ログイン情報を記憶</label>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="loginForm__button">
                                <button
                                    @click="login"
                                    class="loginForm__login"
                                    type="button"
                                >
                                    ログイン
                                </button>
                                <span>パスワードをお忘れですか？</span>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
// ログインページ
import Header from "../components/Header.vue";
import axios from "axios";
import { ref } from "vue";
import router from "../router";
import { Login } from "../type/AuthType";

const errorMessage = ref("");
const valiErrorMessage = ref({ email: "", password: "" });
const password = ref("");
const email = ref("");

const login = async () => {
    valiErrorMessage.value = { email: "", password: "" };
    errorMessage.value = "";
    await axios
        .get("/sanctum/csrf-cookie")
        .then(() => {
            axios
                .post<Login>(`/api/user/login`, {
                    password: password.value,
                    email: email.value,
                })
                .then(() => {
                    router.push("/dash_board");
                })
                .catch((err) => {
                    if (err.response.status == 400) {
                        const ErrorRes = err.response.data.errors;
                        valiErrorMessage.value = ErrorRes;
                    } else {
                        alert("ログインに失敗しました。");
                    }
                });
        })
        .catch(() => {
            alert("ログインに失敗しました。");
        });
};
</script>
<style lang="scss" scoped>
.login {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
}
.loginForm__box {
    border: 2px solid rgb(225, 225, 225);
    width: 40rem;
    font-weight: bold;
}
.loginForm__table {
    margin: 2rem auto 3rem;
}
.loginForm__heading {
    background-color: rgb(219, 219, 219);
    height: 4rem;
    font-size: 1.2rem;
    padding-left: 2rem;
    display: flex;
    align-items: center;
    border-bottom: 2px solid rgb(225, 225, 225);
}
.login__Form__tr {
    height: 38px;
}
.loginForm__label {
    width: 10rem;
}
.loginForm__button {
    span {
        font-weight: 100;
        color: gray;
        margin-left: 1rem;
    }
}
.visually-hidden {
    position: absolute;
    white-space: nowrap;
    border: 0;
    clip: rect(0 0 0 0);
    clip-path: inset(50%);
    overflow: hidden;
    height: 1px;
    width: 1px;
    margin: -1px;
    padding: 0;
}
.error {
    color: red;
}
</style>
