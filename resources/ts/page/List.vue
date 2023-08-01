<template>
    <div class="wrapeer">
        <SideBar />
        <main>
            <h1 class="page__title">お店リスト</h1>
            <button @click="get">get</button>
            <form>
                <div class="input__box col">
                    <input type="text" />
                    <button>検索</button>
                </div>
            </form>
            <div class="list__table">
                <table class="list__table-inner">
                    <thead class="list__table-thead">
                        <tr class="">
                            <th class="list__table-th">ID</th>
                            <th class="list__table-th">店名</th>
                            <th class="list__table-th">カテゴリー</th>
                            <th class="list__table-th">レビュー</th>
                            <th class="list__table-th">コメント</th>
                            <th class="list__table-th">詳細</th>
                            <th class="list__table-th">編集</th>
                            <th class="list__table-th">削除</th>
                        </tr>
                    </thead>
                    <!-- <template v-for="tr in rows" :key="tr.index">
                        <tr>
                            <template
                                v-for="cell in tr.table_cells"
                                :key="cell.index"
                            >
                                <td class="list__table-td">
                                    <p>{{ cell.id }}</p>
                                </td>
                                <td class="list__table-td">
                                    <p>{{ cell.shopName }}</p>
                                </td>
                                <td class="list__table-td">
                                    <p>{{ cell.category }}</p>
                                </td>
                                <td class="list__table-td">
                                    <p>{{ cell.review }}</p>
                                </td>
                                <td class="list__table-td">
                                    <p>{{ cell.comment }}</p>
                                </td>
                                <td class="list__table-td">
                                    <button class="ditail">詳細</button>
                                </td>
                                <td class="list__table-td">
                                    <button class="edit">編集</button>
                                </td>
                                <td class="list__table-td">
                                    <button class="delet">削除</button>
                                </td>
                            </template>
                        </tr>
                    </template> -->
                    <template v-for="item in shopList" :key="item.index">
                        <tr>
                            <td class="list__table-td">
                                <p>{{ item.id }}</p>
                            </td>
                            <td class="list__table-td">
                                <p>{{ item.name }}</p>
                            </td>
                            <td class="list__table-td">
                                <p>{{ item.name_katakana }}</p>
                            </td>
                            <td class="list__table-td">
                                <p>{{ item.review }}</p>
                            </td>
                            <td class="list__table-td">
                                <p>{{ item.food_picture }}</p>
                            </td>
                            <td class="list__table-td">
                                <button class="ditail">詳細</button>
                            </td>
                            <td class="list__table-td">
                                <button class="edit">編集</button>
                            </td>
                            <td class="list__table-td">
                                <button class="delet">削除</button>
                            </td>
                        </tr>
                    </template>
                </table>
            </div>
        </main>
    </div>
</template>
<script lang="ts" setup>
import axios from "axios";
import { defineComponent, ref } from "vue";
import SideBar from "../components/SideBar.vue";

const shopList = ref();
const get = async () => {
    const { data } = await axios.get(`/api/gourmet/`);
    console.log(data);
    shopList.value = data;
    return data;
};
</script>

<style lang="scss" scoped>
.page__title {
    margin-bottom: 2rem;
}

.list__table {
    margin-top: 3rem;
    border: 1px solid #000;
    border-bottom: none;
    font-size: 1rem;
}
.list__table-inner {
    width: 100%;
    text-align: center;
    table-layout: fixed;
    border-collapse: collapse;
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
</style>
