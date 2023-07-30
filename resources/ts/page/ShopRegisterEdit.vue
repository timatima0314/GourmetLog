<template>
    <div class="wrapeer">
        <SideBar />
        <main>
            <h1 class="page__title">お店登録編集</h1>
            <div class="container">
                <form>
                    <div class="input__box column">
                        <label>店名</label>
                        <input type="text" />
                    </div>
                    <div class="input__box column">
                        <label>フリガナ</label>
                        <input type="text" />
                    </div>
                    <div class="input__box column">
                        <dev>カテゴリー</dev>
                        <ul class="input__checkbox-list">
                            <li class="input__checkbox-item">
                                <input
                                    class="input__checkbox"
                                    type="checkbox"
                                /><label>日本料理</label>
                            </li>
                            <li class="input__checkbox-item">
                                <input
                                    class="input__checkbox"
                                    type="checkbox"
                                /><label>日本料理</label>
                            </li>
                        </ul>
                    </div>
                    <div class="input__box column">
                        <label>レビュー（最高：5/最低：1）</label>
                        <select v-model="review">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div class="input__box column">
                        <label>料理画像</label>
                        <input type="file" style="border: none" />
                    </div>
                    <div class="input__box column">
                        <label>Google Map URL</label>
                        <input type="text" />
                    </div>
                    <div class="input__box column">
                        <label>電話番号</label>
                        <input type="text" />
                    </div>
                    <div class="input__box column">
                        <label>コメント</label>
                        <input type="text" />
                    </div>
                </form>
            </div>
        </main>
    </div>
</template>
<script lang="ts" setup>
import { ref } from "vue";
import SideBar from "../components/SideBar.vue";
const review = ref([1, 2, 3, 4, 5]);
</script>
<style lang="scss" scoped>
main {
    margin-top: 1rem;
}
.page__title {
    font-size: 1.3rem;
    text-align: center;
}
.input__checkbox-list {
    display: flex;
    font-weight: normal;
}
.input__checkbox-item {
    list-style-type: none;
    margin-right: 1rem;
}
.input__checkbox {
    width: 1rem;
}
</style>
