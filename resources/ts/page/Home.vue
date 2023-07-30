<template>
    <Header />
    <div class="home__background">
        <div class="home__title-area">
            <h1 class="home__title">Gourmet Log</h1>
        </div>
    </div>
</template>
<script lang="ts" setup>
import Header from "../components/Header.vue";
</script>
<style lang="scss" scoped>
.home__background {
    background-image: url("/images/home_bac.png");
    background-position: center center;
    background-size: cover;
    height: 1000px;
    display: flex;
    align-items: center;
    background-repeat: no-repeat;
}
.home__title-area {
    height: 200px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(255, 255, 255, 0.5);
    border-top: 2px solid rgb(79, 171, 180);
    border-bottom: 2px solid rgb(79, 171, 180);
}
.home__title {
    font-family: cursive;
    font-size: 5rem;
}
</style>
