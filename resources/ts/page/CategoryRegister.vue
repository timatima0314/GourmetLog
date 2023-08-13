<template>
    <div class="wrapeer">
        <SideBar />
        <main>
            <h1 class="page__title">カテゴリー管理</h1>
            <form @submit.prevent class="form__categorie">
                <div class="form__title">新規カテゴリー</div>
                <div class="input__box">
                    <input type="text" v-model="formName" />
                    <button @click="createCategory">登録</button>
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
                    <template
                        v-for="(item, i) in listCategorie"
                        :key="item.index"
                    >
                        <tr>
                            <td class="list__table-td">
                                <p>{{ i+1 }}</p>
                            </td>
                            <td class="list__table-td">
                                <p>{{ item.name }}</p>
                            </td>
                            <td class="list__table-td">
                                <button
                                    :data-index="i"
                                    :data-id="item.id"
                                    class="edit"
                                    @click="edit"
                                >
                                    編集
                                </button>
                            </td>
                            <td class="list__table-td">
                                <button
                                    @click="delConfOpen(item.id)"
                                    class="delet"
                                >
                                    削除
                                </button>
                            </td>
                        </tr>
                    </template>
                </table>
            </div>
        </main>
    </div>
</template>
<script lang="ts" setup>
import SideBar from "../components/SideBar.vue";
import { categorieGet, categorieCreate, destroy } from "../../api/categorieApi";
import { ref, createApp, onMounted } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const formName = ref("");
const listCategorie = ref();

const createCategory = async () => {
    await categorieCreate({ name: formName.value, user_id: 1 });
    formName.value = "";
    getCategory();
};
const getCategory = async () => {
    listCategorie.value = await categorieGet();
};
const delConfOpen = async (id: number) => {
    const delConf = confirm("本当に削除してもよろしいでしょうか？");
    if (delConf) {
        destroy(id)
            .then(async () => {
                await getCategory();
            })
            .catch((Error) => {
                throw new Error(`${Error.message}: destroyApi失敗`);
            });
    }
};
const edit = (e) => {
    const index = e.target.dataset.index;
    const id = e.target.dataset.id;
    router.push({
        name: "CategoryEdit",
        query: {
            id: id,
        },
    });
};
onMounted(() => {
    getCategory();
});
</script>
<style lang="scss" scoped>
.page__title {
    font-size: 1.2rem;
}
.form__categorie {
    margin-top: 2rem;
}
.form__title {
    font-size: 1.5rem;
}
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
