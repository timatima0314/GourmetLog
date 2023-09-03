<template>
    <div class="wrapeer">
        <SideBar />
        <main>
            <h1 class="page__title">お店リスト</h1>
            <form @submit.prevent>
                <div class="input__box col">
                    <input type="text" v-model="searchKey" required />
                    <button @click="keySearch">検索</button>
                </div>
            </form>
            <div class="searchClear" v-if="search">
                検索ワード"{{ searchKey }}"<button @click="searchClear">
                    クリア
                </button>
            </div>
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
                                <p>{{ item.listId }}</p>
                            </td>
                            <td class="list__table-td">
                                <p>{{ item.name }}</p>
                            </td>
                            <td class="list__table-td">
                                <span v-for="one in item.categories" :key="one">
                                    <span
                                        v-if="item.categories"
                                        style="margin-right: 0.5rem"
                                    >
                                        {{ one.name }}
                                    </span>
                                </span>
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
            <ul v-if="shopListDataTotal > 10 && !search" class="pagination">
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
            <button @click="csvDownload" style="margin-top: 1rem; float: right">
                CSVダウンロード
            </button>
        </main>
    </div>
</template>
<script lang="ts" setup>
// お店リストページ
import { onMounted, ref, computed } from "vue";
import { destroy, restaurantDataGetAll } from "../../api/restaurantApi";
import SideBar from "../components/SideBar.vue";
import { useStore } from "../store/store";
import * as MutationTypes from "../store/mutationTypes";
import { useRouter } from "vue-router";
import axios from "axios";
import { pick } from "lodash";
import {
    RestaurantData,
    PageNationData,
    CsvData,
} from "../../ts/type/RestaurantType";

const router = useRouter();
const store = useStore();

const searchKey = ref("");
const search = ref(false); // tureであれば検索状態
const shopList = ref(); // DB::restaurantData(PageNation数,つまり１０件)
const shopListDataTotal = ref<number>(0); //DB::restaurantData全て
const current_page = ref(1); //現在のページ
const last_page = ref(0);
const pageLinks = ref();
const pageLinksLength = ref(0);

const listId = computed(() => {
    return current_page.value * 10 - 9;
});

// DB::restaurantData10件を取得。
const getRestaurantData = async () => {
    const { data } = await axios.get<PageNationData>(
        `/api/gourmet?page=${current_page.value}`
    );
    return data;
};

const createPageNation = async () => {
    const restaurantData: PageNationData = await getRestaurantData();
    last_page.value = restaurantData.last_page;
    pageLinksLength.value = restaurantData.links.length;
    pageLinks.value = restaurantData.links;
    shopListDataTotal.value = restaurantData.total;
};
const shopDataGet = async () => {
    try {
        await createPageNation();
        const restaurantData: PageNationData = await getRestaurantData();
        const { data } = restaurantData;
        // DB::restaurant.categorieはjsonなので変換する。
        data.map((item, i) => {
            item.listId = listId.value + i;
        });
        shopList.value = data;
    } catch (e) {
        alert("データ取得に失敗しました。");
    }
};
const changePageNation = async (e) => {
    const label = e.target.dataset.label; //移行したいPageNation番号
    if (current_page.value == label) return;

    current_page.value = Number(label);
    const { data } = await axios.get<PageNationData>(
        `/api/gourmet?page=${label}`
    );
    const linkData = data.data; // 移行先のdata
    linkData.map((item, i) => {
        item.listId = listId.value + i;
    });
    shopList.value = linkData; // 移行先のdataに更新。
};

const backPageNation = async () => {
    if (current_page.value === 1) return;
    const back = current_page.value - 1;
    current_page.value = back;
    const { data } = await axios.get<PageNationData>(
        `/api/gourmet?page=${back}`
    );
    const linkData = data.data;
    linkData.map((item, i) => {
        item.listId = listId.value + i;
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
    linkData.map((item, i) => {
        item.listId = listId.value + i;
    });
    shopList.value = linkData;
};

// 検索
const keySearch = async () => {
    if (searchKey.value == "") return;
    const dataAll = await restaurantDataGetAll();
    dataAll.map((item: RestaurantData, i) => {
        item.listId = listId.value + i;
    });
    const searchList = dataAll.filter((item: RestaurantData) => {
        return item.name == searchKey.value;
    });
    shopList.value = searchList;
    search.value = true;
};

const searchClear = () => {
    location.reload();
};

// 編集ページへ
const edit = async (e) => {
    const index = e.target.dataset.index;
    const id = e.target.dataset.id;
    shopList.value[index].categories.map((item) => {
        item.select = true;
    });
    const {
        name,
        name_katakana,
        review,
        food_picture,
        map_url,
        comment,
        tel,
        user_id,
        categories,
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
        categories: categories,
    });
    router.push({
        name: "ShopRegisterEdit",
        query: {
            id: id,
            user_id: user_id,
        },
    });
};

// 詳細画面へ
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
        categories,
    } = shopList.value[index];
    store.commit(MutationTypes.ADD_RESTAURANT_DETA, {
        name: name,
        name_katakana: name_katakana,
        review: review,
        food_picture: food_picture,
        map_url: map_url,
        comment: comment,
        tel: tel,
        categories: categories,
    });
    router.push({
        name: "Ditail",
        query: {
            id: id,
        },
    });
};

// 削除
const delConfOpen = async (id: number) => {
    const delConf = confirm("本当に削除してもよろしいでしょうか？");
    if (delConf) {
        destroy(id)
            .then(async () => {
                await shopDataGet();
            })
            .catch(() => {
                alert("削除に失敗しました。");
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
const csvDownload = () => {
    const _pick: any = [];
    shopList.value.map((item) => {
        let csvData: CsvData = pick(item, [
            "listId",
            "name",
            "categories",
            "review",
            "comment",
        ]);
        _pick.push(csvData);
    });
    // ////////////////////出力するデータの作成////////////////////
    // // CSV格納用 ※ヘッダーをあらかじめ設定しておく
    const header = "ID,店名,カテゴリー,レビュー,コメント\r\n";
    let data = header;
    // // オブジェクトの中身を取り出してカンマ区切りにする
    for (let sample of _pick) {
        data += sample.listId + ",";
        data += sample.name + ",";
        for (let i = 0; i < sample.categories.length; i++) {
            if (sample.categories.length == i + 1) {
                data += sample.categories[i].name + ",";
            } else {
                data += sample.categories[i].name + "、";
            }
        }
        data += sample.review + ",";
        data += sample.comment;
        // データ末尾に改行コードを追記
        data += "\r\n";
    }

    ////////////////////CSV形式へ変換////////////////////
    // BOMを付与（Excelで開いた際のの文字化け対策）
    const bom = new Uint8Array([0xef, 0xbb, 0xbf]);
    // CSV用バイナリデータを作成
    const blob = new Blob([bom, data], { type: "text/csv" });
    // blobからオブジェクトURLを作成
    const objectUrl = URL.createObjectURL(blob);

    ////////////////////ダウンロードリンクの作成とクリック////////////////////
    // ダウンロードリンクを作成 ※HTMLのaタグを作成
    const downloadLink = document.createElement("a");
    // ファイル名の設定
    const fileName = "sample.csv";
    downloadLink.download = fileName;
    // ダウンロードファイルを設定 ※aタグのhref属性
    downloadLink.href = objectUrl;

    // ダウンロードリンクを擬似的にクリック
    downloadLink.click();

    // ダウンロードリンクを削除
    downloadLink.remove();
};
onMounted(async () => {
    storeClear();
    await shopDataGet();
});
</script>

<style lang="scss" scoped>
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
.current {
    color: blue;
}
</style>
