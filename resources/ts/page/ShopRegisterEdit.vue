<template>
    <div class="wrapeer">
        <SideBar />
        <main>
            <h1 class="page__title">お店登録編集</h1>
            <div class="container">
                <form>
                    <div class="input__box column">
                        <label>店名</label>
                        <input type="text" v-model="form.name" />
                    </div>
                    <div class="input__box column">
                        <label>フリガナ</label>
                        <input type="text" v-model="form.name_katakana" />
                    </div>
                    <div class="input__box column">
                        <dev>カテゴリー</dev>
                        <ul class="input__checkbox-list">
                            <li class="input__checkbox-item">
                                <input
                                    class="input__checkbox"
                                    type="checkbox"
                                /><label>日本料理</label>
                            </li>
                            <li class="input__checkbox-item">
                                <input
                                    class="input__checkbox"
                                    type="checkbox"
                                /><label>日本料理</label>
                            </li>
                        </ul>
                    </div>
                    <div class="input__box column">
                        <label>レビュー（最高：5/最低：1）</label>
                        <select v-model="form.review">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div class="input__box column">
                        <label>料理画像</label>
                        <input
                            type="text"
                            style="border: none"
                            v-model="form.food_picture"
                        />
                    </div>
                    <div class="input__box column">
                        <label>Google Map URL</label>
                        <input type="text" v-model="form.map_url" />
                    </div>
                    <div class="input__box column">
                        <label>電話番号</label>
                        <input type="text" v-model="form.tel" />
                    </div>
                    <div class="input__box column">
                        <label>コメント</label>
                        <input type="text" v-model="form.comment" />
                    </div>
                    <div class="button_box">
                        <button class="goto_confirmation_screen" @click="post">
                            確認画面へ
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</template>
<script lang="ts" setup>
import axios from "axios";
import { ref, reactive, computed } from "vue";
import SideBar from "../components/SideBar.vue";
import { useStore } from "../store/store";
import * as MutationTypes from "../store/mutationTypes";
import { useRouter } from "vue-router";

const router = useRouter();

const form = reactive({
    name: "",
    name_katakana: "",
    review: 1,
    food_picture: "",
    map_url: "",
    comment: "",
    tel: "",
    user_id: 1,
});
const store = useStore();
const restaurantData = computed(() => store.state.restaurantData);
// 'user_id', 'name', 'name_katakana', 'review', 'food_picture', 'map_url', 'comment', 'tel'
// const post = async () => {
//     console.log(shopDate);
//     const { data } = await axios.post(`/api/gourmet`, shopDate);
//     return data;
// };
const lengths = () => {
    console.log(store.state.restaurantData.length);
};

const clearForm = () => {
    form.name = "";
    form.name_katakana = "";
    form.review = 1;
    form.food_picture = "";
    form.map_url = "";
    form.comment = "";
    form.tel = "";
    form.user_id = 1;
};
const post = () => {
    store.commit(MutationTypes.ADD_RESTAURANT_DETA, {
        name: form.name,
        name_katakana: form.name_katakana,
        review: form.review,
        food_picture: form.food_picture,
        map_url: form.map_url,
        comment: form.comment,
        tel: form.tel,
        user_id: 1,
    });
    router.push("/confirmation");
};
</script>
<style lang="scss" scoped>
main {
    margin-top: 1rem;
}
.page__title {
    font-size: 1.3rem;
    text-align: center;
}
.input__checkbox-list {
    display: flex;
    font-weight: normal;
}
.input__checkbox-item {
    list-style-type: none;
    margin-right: 1rem;
}
.input__checkbox {
    width: 1rem;
}
.button_box {
    text-align: center;
}
.goto_confirmation_screen {
    background-color: #fff;
    color: #000;
}
</style>
