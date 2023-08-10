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
                                <!-- {{ restaurantData.name }} -->
                            </div>
                        </div>
                        <div class="item__box">
                            <div class="item__title">フリガナ:</div>
                            <div class="item__date">
                                <!-- {{ restaurantData.name_katakana }} -->
                            </div>
                        </div>
                        <div style="display: flex">
                            <div
                                class="item__box column"
                                style="margin: 0 2rem 1rem 0"
                            >
                                <div class="item__title">カテゴリー:</div>
                                <div class="item__date">日本料理</div>
                            </div>
                            <div class="item__box column" style="margin: 0">
                                <div class="item__title">レビュー:</div>
                                <div class="item__date">
                                    <!-- {{ restaurantData.review }} -->
                                </div>
                            </div>
                        </div>
                        <div class="item__box column">
                            <div class="item__title">料理写真:</div>
                            <div class="item__date">
                                <img
                                 width="250" height="180" src=""/>
                            </div>
                        </div>
                        <div class="item__box column">
                            <div class="item__title">Google Map URL:</div>
                            <div class="item__date">
                                <!-- {{ restaurantData.map_url }} -->
                            </div>
                        </div>
                        <div class="item__box column">
                            <div class="item__title">電話番号:</div>
                            <div class="item__date">
                                <!-- {{ restaurantData.tel }} -->
                            </div>
                        </div>
                        <div class="item__box column">
                            <div class="item__title">コメント:</div>
                            <div class="item__date">
                                <!-- {{ restaurantData.comment }} -->
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
