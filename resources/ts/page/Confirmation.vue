<template>
    <div class="wrapeer">
        <SideBar />
        <main>
            <h1 class="page__title">新規登録　確認画面</h1>
            <div class="container column">
                <div class="item__container">
                    <div class="item__box">
                        <div class="item__title">店名:</div>
                        <div class="item__date">{{ restaurantData.name }}</div>
                    </div>
                    <div class="item__box">
                        <div class="item__title">フリガナ:</div>
                        <div class="item__date">
                            {{ restaurantData.name_katakana }}
                        </div>
                    </div>
                    <div class="item__box">
                        <div class="item__title">カテゴリー:</div>
                        <div class="item__date">日本料理</div>
                    </div>
                    <div class="item__box">
                        <div class="item__title">レビュー:</div>
                        <div class="item__date">
                            {{ restaurantData.review }}
                        </div>
                    </div>
                    <div class="item__box">
                        <div class="item__title">料理写真:</div>
                        <div class="item__date">
                            {{ restaurantData.food_picture }}
                        </div>
                    </div>
                    <div class="item__box">
                        <div class="item__title">Google Map URL:</div>
                        <div class="item__date">
                            {{ restaurantData.map_url }}
                        </div>
                    </div>
                    <div class="item__box">
                        <div class="item__title">電話番号:</div>
                        <div class="item__date">{{ restaurantData.tel }}</div>
                    </div>
                    <div class="item__box">
                        <div class="item__title">コメント:</div>
                        <div class="item__date">
                            {{ restaurantData.comment }}
                        </div>
                    </div>
                    <div class="button__box">
                        <button class="fix" @click="">修正する</button>
                        <button class="register" @click="">登録する</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
<script lang="ts" setup>
import SideBar from "../components/SideBar.vue";
import { useStore } from "../store/store";
import { computed } from "vue";
const store = useStore();
const length = store.state.restaurantData.length - 1;
const restaurantData = computed(() => store.state.restaurantData[length]);
const fff = () => {
    const oo = store.state.restaurantData[2];
    console.log(oo);
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
    margin-bottom: 2rem;
    display: flex;
}
.button__box{
    display: flex;
    justify-content: space-between;
}
.fix {
    color: #000;
}
</style>
