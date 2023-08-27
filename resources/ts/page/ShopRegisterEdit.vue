<template>
    <div class="wrapeer">
        <SideBar />
        <main>
            <h1 class="page__title">お店登録編集</h1>
            <div class="container">
                <form>
                    <div class="input__box column">
                        <label>店名<span class="required">*</span></label>
                        <input type="text" v-model="form.name" />
                    </div>
                    <div class="input__box column">
                        <label>フリガナ<span class="required">*</span></label>
                        <input type="text" v-model="form.name_katakana" />
                    </div>
                    <div class="input__box column">
                        <dev>カテゴリー<span class="required">*</span></dev>
                        <ul class="input__checkbox-list">
                            <li
                                v-for="(item, i) in categorieList"
                                :key="i"
                                class="input__checkbox-item"
                            >
                                <input
                                    class="input__checkbox"
                                    type="checkbox"
                                    :value="item.name"
                                    v-model="item.select"
                                /><label>{{ item.name }}</label>
                            </li>
                        </ul>
                    </div>
                    <div class="input__box column">
                        <label
                            >レビュー（最高：5/最低：1）<span class="required"
                                >*</span
                            ></label
                        >
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
                        <label>Google Map キーワード</label>
                        <input type="text" v-model="form.map_url" />
                    </div>
                    <div class="input__box column">
                        <label>電話番号</label>
                        <input type="text" v-model="form.tel" />
                    </div>
                    <div class="input__box column">
                        <label>コメント<span class="required">*</span></label>
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
// DB::restaurant登録、編集ページ
import { ref, reactive, computed, onMounted } from "vue";
import SideBar from "../components/SideBar.vue";
import { categorieGet } from "../../api/categorieApi";
import { useStore } from "../store/store";
import * as MutationTypes from "../store/mutationTypes";
import { useRoute } from "vue-router";
import router from "../router";
import { Categorie } from "../type/RestaurantType";
import { authGet } from "../../api/authApi";

const _router = useRoute();

const fileUrl = ref("");
const fileUrlEdit = ref("");
const propUserId = ref(); // authUserId
const propEditId = ref(); // 編集するrestaurantId
const categorieList = ref<[Categorie]>();
const store = useStore();
// 料理画像file_input
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
    user_id: propUserId,
    checkCategorie: <any>[],
    checkCategorieId: <any>[],
});
const inputCategorieId = () => {
    if (!categorieList.value) return;
    let _input: any = [];
    categorieList.value.map((item) => {
        if (item.select) {
            _input.push(item.id);
        }
    });
    return _input;
};
const inputCategorieName = () => {
    if (!categorieList.value) return;
    let _input: any = [];
    categorieList.value.map((item) => {
        if (item.select) {
            _input.push(item.name);
        }
    });
    return _input;
};

const result = store.state.restaurantData.length - 1; // srote.state.restaurantDataの最後のdata。つまり登録したいdata.
const restaurantData = computed(() => {
    return store.state.restaurantData[result];
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
    categories,
} = restaurantData.value;

// srote.state.restaurantDataを代入。つまり編集するデータ。
const listItemGet = async () => {
    form.name = name;
    form.name_katakana = name_katakana;
    form.review = review;
    form.food_picture = food_picture;
    form.map_url = map_url;
    form.comment = comment;
    form.tel = tel;
    form.user_id = user_id;
    const _categories: any = [];
    if (propEditId.value) {
        categories.map((item: any) => {
            _categories.push(item.name);
        });
        form.checkCategorie = _categories;
    } else {
        categorieList.value?.map((item) => {
            _categories.push(item);
        });
        form.checkCategorie = _categories;
    }
};

const authUserIdGet = async () => {
    await authGet().then((res) => {
        propUserId.value = res.user.id;
    });
};

//編集モードの時カテゴリーを選択されたrestaurantのカテゴリを代入.
const categorieSelect = async () => {
    let categoreItems = await categorieGet();
    categoreItems.map((item, index, array) => {
        categories.map((val) => {
            if (item.name == val.name) {
                array[index].select = true;
            }
        });
    });
    categorieList.value = categoreItems;
};

//新規登録時
const categorieSelectNoEdit = async () => {
    const categoreItems = await categorieGet();
    categoreItems.map((item) => {
        item.select = false;
    });
    categorieList.value = categoreItems;
};

onMounted(async () => {
    propEditId.value = _router.query.id;
    authUserIdGet();
    await listItemGet();

    if (food_picture) {
        propEditId.value
            ? (fileUrlEdit.value = food_picture)
            : (fileUrl.value = URL.createObjectURL(food_picture));
    }
    // propEditIdにidが代入時は編集モード、undefinedの場合新規登録モード
    propEditId.value ? await categorieSelect() : await categorieSelectNoEdit();
});

const toConfirmation = () => {
    store.commit(MutationTypes.ADD_RESTAURANT_DETA, {
        name: form.name,
        name_katakana: form.name_katakana,
        review: form.review,
        food_picture: form.food_picture,
        map_url: form.map_url,
        comment: form.comment,
        tel: form.tel,
        user_id: form.user_id,
        categories: inputCategorieName(),
        categorieId: inputCategorieId(),
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
    width: 20rem;
    flex-wrap: wrap;
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
