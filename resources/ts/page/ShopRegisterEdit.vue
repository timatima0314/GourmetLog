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
                            type="file"
                            style="border: none"
                            @change="fileSelected"
                        />
                        <img
                            v-if="fileUrlEdit"
                            alt="料理画像"
                            width="250"
                            height="180"
                            :src="`storage/${fileUrlEdit}`"
                        /><img
                            v-else-if="fileUrl"
                            alt="料理画像"
                            width="250"
                            height="180"
                            :src="fileUrl"
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
                        <button
                            class="goto_confirmation_screen"
                            @click="toConfirmation"
                        >
                            確認画面へ
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</template>
<script lang="ts" setup>
import { ref, reactive, computed, onMounted } from "vue";
import SideBar from "../components/SideBar.vue";
import { useStore } from "../store/store";
import * as MutationTypes from "../store/mutationTypes";
import { useRoute } from "vue-router";
import router from "../router";

const fileUrl = ref("");
const fileUrlEdit = ref("");

const _router = useRoute();
const propEditId = ref();

const fileSelected = (event) => {
    const file = event.target.files[0];
    form.food_picture = file;
    fileUrlEdit.value = "";
    fileUrl.value = URL.createObjectURL(file);
};
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
const lengths = store.state.restaurantData.length - 1;
const restaurantData = computed(() => {
    return store.state.restaurantData[lengths];
});
const {
    name,
    name_katakana,
    comment,
    food_picture,
    map_url,
    review,
    tel,
    user_id,
} = restaurantData.value;

const listItemGet = () => {
    form.name = name;
    form.name_katakana = name_katakana;
    form.review = review;
    form.food_picture = food_picture;
    form.map_url = map_url;
    form.comment = comment;
    form.tel = tel;
    form.user_id = user_id;
};

onMounted(async () => {
    await listItemGet();
    propEditId.value = _router.query.id;
    if (food_picture) {
        propEditId.value
            ? (fileUrlEdit.value = food_picture)
            : (fileUrl.value = URL.createObjectURL(food_picture));
    }
});

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
const toConfirmation = () => {
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
    propEditId
        ? router.push({
              name: "Confirmation",
              query: {
                  id: propEditId.value,
              },
          })
        : router.push("/confirmation");
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
