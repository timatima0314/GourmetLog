<template>
    <div class="wrapeer">
        <SideBar />
        <main>
            <div class="heading">{{ month }}月{{ day }}日</div>
            <div class="heading">{{ userName }}さん　{{ greeting }}</div>
            <div class="heading">{{ oneWord }}</div>
            <div class="list__table">
                <table class="list__table-inner">
                    <thead class="list__table-thead">
                        <tr class="">
                            <th class="list__table-th">店名</th>
                            <th class="list__table-th">カテゴリー</th>
                            <th class="list__table-th">コメント</th>
                            <th style="width: 5rem" class="list__table-th">
                                詳細
                            </th>
                        </tr>
                    </thead>
                    <template v-for="(item, i) in shopList" :key="item.i">
                        <tr>
                            <td class="list__table-td">
                                <p>{{ item.name }}</p>
                            </td>
                            <td class="list__table-td">
                                <p>{{ item.genre.name }}</p>
                            </td>
                            <td class="list__table-td" style="text-align: left">
                                <p>{{ item.catch }}</p>
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
                        </tr>
                    </template>
                </table>
            </div>
            <ul class="pagination">
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
                        :class="[current_page == link.label ? 'current' : null]"
                    >
                        {{ link.label }}
                    </div>
                </li>
            </ul>
        </main>
    </div>
</template>
<script lang="ts" setup>
// ダッシュボードページ
import { authGet } from "../../api/authApi";
import { onMounted, ref } from "vue";
import SideBar from "../components/SideBar.vue";
import axios from "axios";
import { PageNationHotpepperData } from "../type/RestaurantType";
import { useRouter } from "vue-router";
import { useStore } from "../store/store";
import * as MutationTypes from "../store/mutationTypes";

const router = useRouter();
const store = useStore();

const userName = ref("");
const month = ref<number>();
const day = ref<number>();
const greeting = ref("");
const oneWord = ref("");
const shopList = ref();
const current_page = ref(1); //現在のページ
const last_page = ref(0);
const pageLinks = ref();
const pageLinksLength = ref(0);
const get = async () => {
    const { data } = await axios.get("/api/index");
    shopList.value = data.data;
};
const createPageNation = async () => {
    const { data }: PageNationHotpepperData = await axios.get("/api/index");
    last_page.value = data.last_page;
    pageLinksLength.value = data.links.length;
    pageLinks.value = data.links;
};
const changePageNation = async (e) => {
    const label = e.target.dataset.label; //移行したいPageNation番号
    if (current_page.value == label) return;

    current_page.value = Number(label);
    const { data } = await axios.get<PageNationHotpepperData>(
        `/api/index?page=${label}`
    );
    const linkData = data.data; // 移行先のdata
    shopList.value = linkData; // 移行先のdataに更新。
};
const backPageNation = async () => {
    if (current_page.value === 1) return;
    const back = current_page.value - 1;
    current_page.value = back;
    const { data } = await axios.get<PageNationHotpepperData>(
        `/api/index?page=${back}`
    );
    const linkData = data.data;
    shopList.value = linkData;
};

const nextPageNation = async () => {
    if (current_page.value == last_page.value) return;
    const next = current_page.value + 1;
    current_page.value = next;
    const { data } = await axios.get<PageNationHotpepperData>(
        `/api/index?page=${next}`
    );
    const linkData = data.data;
    shopList.value = linkData;
};

// 詳細画面へ
const goDitail = (e) => {
    const index = e.target.dataset.index;

    const {
        name,
        name_kana,
        photo,
        address,
        genre,
    } = shopList.value[index];
    store.commit(MutationTypes.ADD_RESTAURANT_DETA, {
        name: name,
        name_katakana: name_kana,
        food_picture: photo.pc.l,
        map_url: address,
        comment: genre.catch,
        categories: genre.name,
    });
    router.push("/hotpepper_data_ditail");
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

const toDay = () => {
    let today = new Date();
    month.value = today.getMonth() + 1;
    day.value = today.getDate();

    let hours = today.getHours();
    if (hours >= 5 && hours <= 8) {
        greeting.value = "おはようございます！";
        oneWord.value = "今日のランチは決めましたか？";
    } else if (hours >= 9 && hours <= 16) {
        greeting.value = "こんにちは！";
        oneWord.value = "今日のディナーはもう決めましたか？";
    } else {
        greeting.value = "こんばんは！";
        oneWord.value = "明日のモーニングはもう決めましたか？";
    }
};
const getUserName = async () => {
    const { user } = await authGet();
    userName.value = user.name;
};
onMounted(async () => {
    storeClear();
    toDay();
    getUserName();
    get();
    await createPageNation();
});
</script>
<style lang="scss" scoped>
.heading {
    line-height: 2.2rem;
}
.page__title {
    margin-bottom: 2rem;
}
.searchClear {
    color: #000;
    margin-top: 0.5rem;
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
.current {
    color: blue;
}
</style>
