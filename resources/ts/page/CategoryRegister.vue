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
                <div class="err">
                    <div v-if="valiErrorMessage">
                        {{ valiErrorMessage.name[0] }}
                    </div>
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
                                <p>{{ i + 1 }}</p>
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
// カテゴリー新規登録ページ
import SideBar from "../components/SideBar.vue";
import { categorieGet, categorieCreate, destroy } from "../../api/categorieApi";
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import { Categorie } from "../type/RestaurantType";
import { authGet } from "../../api/authApi";

const router = useRouter();
const route = useRoute();

const formName = ref("");
const listCategorie = ref<[Categorie]>(); //DB::カテゴリーdeta
const propUserId = ref(); // authUserId
const valiErrorMessage = ref({
    name: "",
});

const createCategory = async () => {
    await categorieCreate({ name: formName.value, user_id: propUserId.value })
        .then(() => {
            formName.value = "";
            valiErrorMessage.value = { name: "" };
        })
        .catch((err) => {
            if (err.response.status == 400) {
                const ErrorRes = err.response.data.errors;
                valiErrorMessage.value = ErrorRes;
            } else {
                alert("カテゴリー登録に失敗しました。");
            }
        });
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
            .catch(() => {
                alert("カテゴリー削除に失敗しました。");
            });
    }
};

// DB::カテゴリーidを所得しクエリ文字列とし,編集ページへ
const edit = (e) => {
    const id = e.target.dataset.id;
    router.push({
        name: "CategoryEdit",
        query: {
            id: id,
        },
    });
};

const authUserIdGet = async () => {
    await authGet().then((res) => {
        propUserId.value = res.user.id;
    });
};

onMounted(() => {
    authUserIdGet();
    getCategory();
    propUserId.value = route.query.user_id;
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
.err {
    height: 1rem;
}
</style>
