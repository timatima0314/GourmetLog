<template>
    <div class="wrapeer">
        <SideBar />
        <main>
            <h1 class="page__title">詳細画面</h1>
            <form @submit.prevent enctype="multipart/form-data">
                <div class="container column">
                    <div class="item__container">
                        <div class="item__box">
                            <div class="item__title">店名:</div>
                            <div class="item__date">
                                {{ name }}
                            </div>
                        </div>
                        <div class="item__box">
                            <div class="item__title">フリガナ:</div>
                            <div class="item__date">
                                {{ name_katakana }}
                            </div>
                        </div>
                        <div style="display: flex">
                            <div
                                class="item__box column"
                                style="margin: 0 2rem 1rem 0"
                            >
                                <div class="item__title">カテゴリー:</div>
                                <div class="item__date">
                                    <span
                                        v-for="one in categorie"
                                        :key="one"
                                        style="margin-right: 0.5rem"
                                        >{{ one }}</span
                                    >
                                </div>
                            </div>
                            <div class="item__box column" style="margin: 0">
                                <div class="item__title">レビュー:</div>
                                <div class="item__date">
                                    {{ review }}
                                </div>
                            </div>
                        </div>
                        <div class="item__box column">
                            <div class="item__title">料理写真:</div>
                            <div class="item__date">
                                <img v-if="food_picture"
                                    width="250"
                                    height="180"
                                    :src="`storage/${food_picture}`"
                                />
                            </div>
                        </div>
                        <div class="item__box column">
                            <div class="item__title">Google Map:</div>
                            <div class="item__date">
                                <iframe v-if="map_url"
                                    :src="`https://maps.google.co.jp/maps?output=embed&q=${map_url}`"
                                    width="300"
                                    height="200"
                                    style="border: 0"
                                    loading="lazy"
                                >
                                </iframe>
                            </div>
                        </div>
                        <div class="item__box column">
                            <div class="item__title">電話番号:</div>
                            <div class="item__date">
                                {{ tel }}
                            </div>
                        </div>
                        <div class="item__box column">
                            <div class="item__title">コメント:</div>
                            <div class="item__date">
                                {{ comment }}
                            </div>
                        </div>
                        <div class="button__box">
                            <router-link to="/list">
                                <button class="back" @click="">
                                    お店リストに戻る
                                </button>
                            </router-link>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</template>
<script lang="ts" setup>
import SideBar from "../components/SideBar.vue";
import { useStore } from "../store/store";
import { computed } from "vue";
const store = useStore();
const lengths = store.state.restaurantData.length - 1;
const restaurantData = computed(() => {
    return store.state.restaurantData[lengths];
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
    categorie,
} = restaurantData.value;
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
    margin-bottom: 2rem;
    display: flex;
    &.column {
        flex-direction: column;
        align-items: baseline;
    }
}
.button__box {
    display: flex;
    text-align: center;
}
.fix {
    color: #000;
}
</style>
