<template>
    <div class="wrapeer">
        <SideBar />
        <main>
            <h1 class="page__title">カテゴリー編集</h1>
            <div class="container">
                <div class="edit__box">
                    <form @submit.prevent>
                        <div class="input__box column">
                            <lavel class="edit__titel">カテゴリー名</lavel>
                            <input
                                class="edit__input"
                                type="text"
                                name="content"
                                v-model="categorieNameEdit"
                            />
                            <div class="error__messages">
                                <!-- <span v-if="errorsMessages">{{ errorsMessages }}</span> -->
                            </div>
                            <div class="edit__button-wrap">
                                <button
                                    type="button"
                                    class="back"
                                    @click="previousScreen"
                                >
                                    戻る
                                </button>
                                <button class="edit" @click="updataCategory">
                                    修正
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</template>
<script lang="ts" setup>
import SideBar from "../components/SideBar.vue";
import { categorieGet, categorieUpdate } from "../../api/categorieApi";
import { useRoute, useRouter } from "vue-router";
import { ref, onMounted } from "vue";

const router = useRouter();
const route = useRoute();

const categorieNameEdit = ref("");
const propEditId = ref();
const propIndexId = ref();

const editItemGet = async () => {
    await categorieGet().then((item) => {
        const filterData = item.filter((val) => {
            return val.id == propEditId.value;
        });
        categorieNameEdit.value = filterData[0].name;
    });
};

const updataCategory = async () => {
    await categorieUpdate({
        name: categorieNameEdit.value,
        id: propEditId.value,
    });
    router.push("/category_register");
};
const previousScreen = () => {
    router.push("/category_register");
};
onMounted(() => {
    propEditId.value = route.query.id;
    propIndexId.value = route.query.indexId;
    editItemGet();
});
</script>
<style lang="scss" scoped>
.page__title {
    font-size: 1.3rem;
    text-align: center;
}
.edit__box {
    margin-top: 3rem;
}
.edit__button-wrap {
    display: flex;
    justify-content: space-between;
    button {
        margin: 1rem 0;
    }
}
</style>
