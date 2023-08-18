<template>
    <div class="wrapeer">
        <SideBar />
        <main>
            <h1 class="page__title">お店リスト</h1>
            <form @submit.prevent>
                <div class="input__box col">
                    <input type="text" v-model="searchKey" />
                    <button @click="keySearch">検索</button>
                </div>
            </form>
            <div class="list__table">
                <table class="list__table-inner">
                    <thead class="list__table-thead">
                        <tr class="">
                            <th style="width: 3rem" class="list__table-th">
                                ID
                            </th>
                            <th class="list__table-th">店名</th>
                            <th class="list__table-th">カテゴリー</th>
                            <th style="width: 4rem" class="list__table-th">
                                レビュー
                            </th>
                            <th class="list__table-th">コメント</th>
                            <th style="width: 5rem" class="list__table-th">
                                詳細
                            </th>
                            <th style="width: 5rem" class="list__table-th">
                                編集
                            </th>
                            <th style="width: 5rem" class="list__table-th">
                                削除
                            </th>
                        </tr>
                    </thead>
                    <template v-for="(item, i) in shopList" :key="item.i">
                        <tr>
                            <td class="list__table-td">
                                <p>{{ i + 1 }}</p>
                            </td>
                            <td class="list__table-td">
                                <p>{{ item.name }}</p>
                            </td>
                            <td class="list__table-td">
                                <span
                                    v-for="one in item.categorie"
                                    :key="one"
                                    style="margin-right: 0.5rem"
                                    >{{ one }}</span
                                >
                            </td>
                            <td class="list__table-td">
                                <p>{{ item.review }}</p>
                            </td>
                            <td class="list__table-td" style="text-align: left">
                                <p>{{ item.comment }}</p>
                            </td>
                            <td class="list__table-td">
                                <button
                                    class="ditail"
                                    :data-index="i"
                                    :data-id="item.id"
                                    @click="goDitail"
                                >
                                    詳細
                                </button>
                            </td>
                            <td class="list__table-td">
                                <button
                                    :data-index="i"
                                    :data-id="item.id"
                                    @click="edit"
                                    class="edit"
                                >
                                    編集
                                </button>
                            </td>
                            <td class="list__table-td">
                                <button
                                    class="delet"
                                    @click="delConfOpen(item.id)"
                                >
                                    削除
                                </button>
                            </td>
                        </tr>
                    </template>
                </table>
            </div>
            <ul v-if="shopListDataTotal > 10" class="pagination">
                <li
                    v-for="(link, i) in pageLinks"
                    :key="link"
                    :data-label="link.label"
                >
                    <div v-if="i == 0" type="button" @click="backPageNation">
                        ＜
                    </div>
                    <div
                        v-else-if="i == pageLinksLength - 1"
                        @click="nextPageNation"
                    >
                        ＞
                    </div>
                    <div
                        v-else
                        type="buttan"
                        @click="changePageNation"
                        :data-label="link.label"
                    >
                        {{ link.label }}
                    </div>
                </li>
            </ul>
        </main>
    </div>
</template>
<script lang="ts" setup>
import { onMounted, ref } from "vue";
import { destroy } from "../../api/restaurantApi";
import SideBar from "../components/SideBar.vue";
import { useStore } from "../store/store";
import * as MutationTypes from "../store/mutationTypes";
import { useRouter } from "vue-router";
import axios from "axios";
import { RestaurantData, PageNationData } from "../../ts/type/RestaurantType";
const router = useRouter();

const store = useStore();
const searchKey = ref("");
const shopList = ref();
const shopListDataTotal = ref<number>(0);
const current_page = ref(1);
const last_page = ref(0);
const pageLinks = ref();
const pageLinksLength = ref(0);
const getRestaurantData = async () => {
    const { data } = await axios.get<PageNationData>(
        `/api/gourmet?page=${current_page.value}`
    );
    return data;
};

const shopDataGet = async () => {
    const restaurantData: PageNationData = await getRestaurantData();
    last_page.value = restaurantData.last_page;
    pageLinksLength.value = restaurantData.links.length;
    pageLinks.value = restaurantData.links;
    shopListDataTotal.value = restaurantData.total;
    const { data } = restaurantData;
    // DBのitem.categorieはjsonなので変換する。
    data.map((item) => {
        item.categorie = JSON.parse(item.categorie);
    });
    shopList.value = data;
};
const changePageNation = async (e) => {
    const label = e.target.dataset.label;
    if (current_page.value == label) return;
    current_page.value = Number(label);

    const { data } = await axios.get<PageNationData>(
        `/api/gourmet?page=${label}`
    );
    const linkData = data.data;
    linkData.map((item) => {
        item.categorie = JSON.parse(item.categorie);
    });
    shopList.value = linkData;
};
const backPageNation = async () => {
    if (current_page.value === 1) return;
    const back = current_page.value - 1;
    current_page.value = back;
    const { data } = await axios.get<PageNationData>(
        `/api/gourmet?page=${back}`
    );
    const linkData = data.data;
    linkData.map((item) => {
        item.categorie = JSON.parse(item.categorie);
    });
    shopList.value = linkData;
};
const nextPageNation = async () => {
    if (current_page.value == last_page.value) return;
    const next = current_page.value + 1;
    current_page.value = next;
    const { data } = await axios.get<PageNationData>(
        `/api/gourmet?page=${next}`
    );
    const linkData = data.data;
    linkData.map((item) => {
        item.categorie = JSON.parse(item.categorie);
    });
    shopList.value = linkData;
};
const keySearch = () => {
    const data = shopList.value;
    const searchList = data.filter((item: RestaurantData) => {
        return item.name == searchKey.value;
    });
    searchKey.value = "";
    shopList.value = searchList;
};
const edit = (e) => {
    const index = e.target.dataset.index;
    const id = e.target.dataset.id;

    const {
        name,
        name_katakana,
        review,
        food_picture,
        map_url,
        comment,
        tel,
        user_id,
        categorie,
    } = shopList.value[index];
    store.commit(MutationTypes.ADD_RESTAURANT_DETA, {
        name: name,
        name_katakana: name_katakana,
        review: review,
        food_picture: food_picture,
        map_url: map_url,
        comment: comment,
        tel: tel,
        user_id: user_id,
        categorie: categorie,
    });
    router.push({
        name: "ShopRegisterEdit",
        query: {
            id: id,
            user_id: user_id,
        },
    });
};
const goDitail = (e) => {
    const index = e.target.dataset.index;
    const id = e.target.dataset.id;

    const {
        name,
        name_katakana,
        review,
        food_picture,
        map_url,
        comment,
        tel,
        user_id,
        categorie,
    } = shopList.value[index];
    store.commit(MutationTypes.ADD_RESTAURANT_DETA, {
        name: name,
        name_katakana: name_katakana,
        review: review,
        food_picture: food_picture,
        map_url: map_url,
        comment: comment,
        tel: tel,
        categorie: categorie,
    });
    router.push({
        name: "Ditail",
        query: {
            id: id,
        },
    });
};

const delConfOpen = async (id: number) => {
    const delConf = confirm("本当に削除してもよろしいでしょうか？");
    if (delConf) {
        destroy(id)
            .then(async () => {
                await shopDataGet();
            })
            .catch((Error) => {
                throw new Error(`${Error.message}: destroyApi失敗`);
            });
    }
};
const storeClear = () => {
    store.commit(MutationTypes.ADD_RESTAURANT_DETA, {
        name: "",
        name_katakana: "",
        review: 1,
        food_picture: "",
        map_url: "",
        comment: "",
        tel: "",
        categorie: [],
    });
};
onMounted(() => {
    storeClear();
    shopDataGet();
});
</script>

<style lang="scss" scoped>
.page__title {
    margin-bottom: 2rem;
}

.list__table {
    margin-top: 3rem;
    border: 1px solid #000;
    border-bottom: none;
    font-size: 0.8rem;
}
.list__table-inner {
    width: 100%;
    text-align: center;
    table-layout: fixed;
    border-collapse: collapse;
    word-wrap: break-word;
}
.list__table-thead {
    padding: 15px;
    border-bottom: 1px solid #000;
    font-weight: bold;
    vertical-align: middle;
}
.list__table-th {
    border-right: 1px solid #000;
    padding: 1.2rem 0;

    &:last-child {
        border: none;
    }
}
.list__table-td {
    border-right: 1px solid #000;
    border-bottom: 1px solid #000;
    padding: 0.5rem;
    &:last-child {
        border-right: none;
    }
}
.pagination {
    display: flex;
    list-style-type: none;
    font-size: 1rem;
    font-weight: normal;
    justify-content: flex-end;
    margin-top: 0.5rem;
}
.pagination li {
    text-align: center;
    cursor: pointer;
    margin-right: 0.5rem;
    :hover {
        text-decoration: underline;
    }
}
</style>
