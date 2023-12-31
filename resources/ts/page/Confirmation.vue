<template>
    <div class="wrapeer">
        <SideBar />
        <main>
            <h1 class="page__title">新規登録　確認画面</h1>
            <form @submit.prevent enctype="multipart/form-data">
                <div class="container column">
                    <div class="item__container">
                        <div class="item__wrapper">
                            <div class="item__box">
                                <div class="item__title">店名:</div>
                                <div class="item__date">
                                    {{ restaurantData.name }}
                                </div>
                            </div>
                            <div class="err">
                                <div v-if="valiErrorMessage.name">
                                    {{ valiErrorMessage.name[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="item__wrapper">
                            <div class="item__box">
                                <div class="item__title">フリガナ:</div>
                                <div class="item__date">
                                    {{ restaurantData.name_katakana }}
                                </div>
                            </div>
                            <div class="err">
                                <div v-if="valiErrorMessage.name_katakana">
                                    {{ valiErrorMessage.name_katakana[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="item__wrapper">
                            <div class="item__box">
                                <div class="item__title">カテゴリー:</div>
                                <div
                                    v-for="item in restaurantData.categories"
                                    :key="item"
                                    class="item__date"
                                    style="margin-right: 0.8rem;"
                                >
                                    {{ item }}
                                </div>
                            </div>
                            <div class="err">
                                <div v-if="valiErrorMessage.categorieId">
                                    {{ valiErrorMessage.categorieId[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="item__wrapper">
                            <div class="item__box">
                                <div class="item__title">レビュー:</div>
                                <div class="item__date">
                                    {{ restaurantData.review }}
                                </div>
                            </div>
                            <div class="err">
                                <div v-if="valiErrorMessage.review">
                                    {{ valiErrorMessage.review[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="item__box column">
                            <div class="item__title">料理写真:</div>
                            <div class="item__date">
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
                        </div>
                        <div
                            class="item__box column"
                            style="margin-bottom: 1rem"
                        >
                            <div class="item__title">Google Map:</div>
                            <div
                                v-if="restaurantData.map_url"
                                class="item__date"
                            >
                                <iframe
                                    :src="`https://maps.google.co.jp/maps?output=embed&q=${restaurantData.map_url}`"
                                    width="300"
                                    height="200"
                                    style="border: 0"
                                    loading="lazy"
                                >
                                </iframe>

                                {{ restaurantData.map_url }}
                            </div>
                        </div>
                        <div class="item__box column">
                            <div class="item__title">電話番号:</div>
                            <div class="item__date">
                                {{ restaurantData.tel }}
                            </div>
                            <div class="err">
                                <div v-if="valiErrorMessage.tel">
                                    {{ valiErrorMessage.tel[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="item__box column">
                            <div class="item__title">コメント:</div>
                            <div class="item__date">
                                {{ restaurantData.comment }}
                            </div>
                            <div class="err">
                                <div v-if="valiErrorMessage.comment">
                                    {{ valiErrorMessage.comment[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="button__box">
                            <button class="fix" @click="previousScreen">
                                修正する
                            </button>
                            <button
                                v-if="!propEditId"
                                class="register"
                                @click="shopDataCreate"
                            >
                                登録する
                            </button>
                            <button
                                v-else
                                class="register"
                                @click="update(propEditId)"
                            >
                                更新する
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</template>
<script lang="ts" setup>
// restaurant登録確認ページ
import SideBar from "../components/SideBar.vue";
import { restaurantCreate, restaurantUpdate } from "../../api/restaurantApi";
import { useStore } from "../store/store";
import * as MutationTypes from "../store/mutationTypes";
import router from "../router";
import { useRoute } from "vue-router";
import { computed, ref, onMounted } from "vue";
import { authGet } from "../../api/authApi";

const _router = useRoute();
const propEditId = ref(); // 編集するDB::restaurantId
const propUserId = ref();
const store = useStore();

const fileUrl = ref("");
const fileUrlEdit = ref("");
const valiErrorMessage = ref({
    name: "",
    name_katakana: "",
    comment: "",
    review: "",
    tel: "",
    categorieId: "",
});
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
    categorieId,
} = restaurantData.value;

// リクエストヘッダー
const config = {
    headers: {
        "content-type": "multipart/form-data",
    },
};

const storeClear = () => {
    store.commit(MutationTypes.ADD_RESTAURANT_DETA, {
        name: "",
        name_katakana: "",
        review: "",
        food_picture: "",
        map_url: "",
        comment: "",
        tel: "",
        categorie: [],
    });
};

const update = async (id: number) => {
    await restaurantUpdate({
        name,
        name_katakana,
        review,
        food_picture,
        map_url,
        comment,
        tel,
        user_id,
        categorieId,
        config,
        id,
    })
        .then(async () => {
            await storeClear();
            router.push("/list");
        })
        .catch(() => {
            alert("更新に失敗しました。");
        });
};

const shopDataCreate = async () => {
    await restaurantCreate({
        name,
        name_katakana,
        comment,
        food_picture,
        map_url,
        review,
        tel,
        user_id,
        categories,
        categorieId,
        config,
    })
        .then(async () => {
            await storeClear();
            router.push("/list");
        })
        .catch((err) => {
            if (err.response.status == 400) {
                const ErrorRes = err.response.data.errors;
                valiErrorMessage.value = ErrorRes;
            } else {
                alert("登録に失敗しました。");
            }
        });
};

// 料理画像表示
const imgShow = () => {
    if (!food_picture) return;
    // propEditIdがtrueの時は編集モードである。
    if (propEditId.value) {
        // food_pictureがstringの場合,すでに登録されている画像である。
        const editJudge = typeof food_picture === "string";
        if (editJudge) {
            fileUrlEdit.value = food_picture;
        } else {
            // food_poctureがfileの場合、新たな画像で更新する。
            fileUrlEdit.value = "";
            fileUrl.value = URL.createObjectURL(food_picture);
        }
    } else {
        // 編集モードでなく登録モードである。
        fileUrl.value = URL.createObjectURL(food_picture);
    }
};

const authUserIdGet = async () => {
    await authGet().then((res) => {
        propUserId.value = res.user.id;
    });
};

onMounted(() => {
    propEditId.value = _router.query.id; // クエリ文字列,編集したいDB::restaurantId
    authUserIdGet();
    imgShow();
});

const previousScreen = () => {
    propEditId
        ? router.push({
              name: "ShopRegisterEdit",
              query: {
                  id: propEditId.value,
              },
          })
        : router.push("/shop_register_edit");
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
.column {
    flex-direction: column;
    align-items: center;
    margin: 0 auto;
    text-align: left;
}
.item__container {
    margin-top: 2rem;
    display: block;
    min-width: 15rem;
}
.item__box {
    /* margin-bottom: 2rem; */
    display: flex;
    &.column {
        flex-direction: column;
        align-items: baseline;
    }
}
.button__box {
    margin-top: 1rem;
    display: flex;
    justify-content: space-between;
}
.fix {
    color: #000;
}
.err {
    height: 1rem;
}
</style>
