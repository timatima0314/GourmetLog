<template>
    <Header />
    <main>
        <div class="singup">
            <div class="singupForm__box">
                <div class="singupForm__heading">新規登録</div>
                <form style="margin-top: 4rem" @submit.prevent>
                    <table class="singupForm__table">
                        <tr class="singupForm__tr">
                            <td class="singupForm__label">名前</td>
                            <td class="singupForm__input-wrap">
                                <input type="text" />
                            </td>
                        </tr>
                        <tr class="singupForm__tr error">
                            <td></td>
                            <!-- <td v-if="errorMessage.name">
                                {{ errorMessage.name[0] }}
                            </td> -->
                            <!-- <td v-else></td> -->
                        </tr>

                        <tr class="singupForm__tr">
                            <td class="singupForm__label">メールアドレス</td>
                            <td class="singupForm__input-wrap">
                                <input type="text" />
                            </td>
                        </tr>
                        <tr class="singupForm__tr error">
                            <td></td>
                            <!-- <td v-if="errorMessage.email">
                                {{ errorMessage.email[0] }}
                            </td> -->
                        </tr>

                        <tr class="singupForm__tr">
                            <td class="singupForm__label">パスワード</td>
                            <td class="singupForm__input-wrap">
                                <input type="password" />
                            </td>
                        </tr>
                        <tr class="login__Form__tr error">
                            <td></td>
                            <!-- <td v-if="errorMessage.password">
                                {{ errorMessage.password[0] }}
                            </td> -->
                        </tr>
                        <tr>
                            <td></td>
                            <td class="singupForm__button">
                                <button>新規登録</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import Header from '../components/Header.vue';
// import { inject, ref, reactive, toRefs } from "vue";
// import { useRouter } from "vue-router";
// import { singUp, login } from "../api/authApi";
// import { key } from "../store/index";
// const router = useRouter();
// const store = inject(key);
// const name = ref("");
// const email = ref("");
// const password = ref("");
// const errorMessage = ref({ name: "", email: "", password: "" });

// const singUpApp = async () => {
//     singUp(name.value, email.value, password.value)
//         .then(() => {
//             store.authUser();
//             login(email.value, password.value)
//                 .then(() => {
//                     store.authUser();
//                     router.push("/");
//                 })
//                 .catch((Error) => {
//                     throw new Error(`${Error}: login失敗`);
//                 });
//         })
//         .catch((Error) => {
//             const ErrorRes = Error.response.data.errors;
//             errorMessage.value = reactive(ErrorRes);
//         });
// };
</script>
<style lang="scss" scoped>
.singup {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
}
.singupForm__box {
    border: 2px solid rgb(225, 225, 225);
    width: 40rem;
    font-weight: bold;
}
.singupForm__table {
    margin: 2rem auto 3rem;
}
.singupForm__heading {
    background-color: rgb(219, 219, 219);
    height: 4rem;
    font-size: 1.2rem;
    padding-left: 2rem;
    display: flex;
    align-items: center;
    border-bottom: 2px solid rgb(225, 225, 225);
}
.singupForm__label {
    width: 10rem;
}
.singupForm__tr {
    height: 38px;
}
.error {
    color: red;
}
.singupForm__button {
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
label {
    cursor: pointer;
    padding-left: 30px;
    position: relative;
}

label::before,
label::after {
    content: "";
    display: block;
    position: absolute;
}

label::before {
    background-color: #fff;
    border-radius: 0%;
    border: 1px solid #ddd;
    width: 20px;
    height: 20px;
    transform: translateY(-50%);
    top: 50%;
    left: 5px;
}

label::after {
    border-bottom: 2px solid #ddd;
    border-left: 2px solid #ddd;
    opacity: 0;
    height: 5px;
    width: 10px;
    transform: rotate(-45deg);
    top: 2px;
    left: 10px;
}

input:checked + label::after {
    opacity: 1;
}
</style>
