<template>
    <div class="wrapeer">
        <SideBar />
        <main>
            <h1 class="page__title">お店リスト</h1>
            <form>
                <div class="input__box">
                    <input type="text" />
                    <button>検索</button>
                </div>
            </form>
            <div class="list__table">
                <table class="list__table-inner">
                    <thead class="list__table-thead">
                        <tr class="">
                            <th class="list__table-th">ID</th>
                            <th class="list__table-th">カテゴリー</th>
                            <th class="list__table-th">編集</th>
                            <th class="list__table-th">削除</th>
                        </tr>
                    </thead>
                    <template v-for="tr in rows" :key="tr.index">
                        <tr>
                            <template
                                v-for="cell in tr.table_cells"
                                :key="cell.index"
                            >
                                <td class="list__table-td">
                                    <p>{{ cell.id }}</p>
                                </td>
                                <td class="list__table-td">
                                    <p>{{ cell.category }}</p>
                                </td>
                                <td class="list__table-td">
                                    <router-link to="/category_edit">
                                        <button class="edit">編集</button>
                                    </router-link>
                                </td>
                                <td class="list__table-td">
                                    <button class="delet">削除</button>
                                </td>
                            </template>
                        </tr>
                    </template>
                </table>
            </div>
        </main>
    </div>
</template>
<script lang="ts" setup>
import SideBar from "../components/SideBar.vue";
import { ref } from "vue";
const rows = ref([
    {
        table_cells: [
            {
                id: 44,
                category: "日本料理",
            },
        ],
    },
    {
        table_cells: [
            {
                id: 44,
                category: "日本料理",
            },
        ],
    },
    {
        table_cells: [
            {
                id: 44,
                category: "日本料理",
            },
        ],
    },
]);
</script>
<style lang="scss" scoped>
.list__table {
    margin-top: 3rem;
    border: 1px solid #000;
    border-bottom: none;
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
