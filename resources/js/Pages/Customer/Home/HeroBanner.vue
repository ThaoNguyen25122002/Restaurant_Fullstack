<template>
    <swiper
        class="mySwiper"
        :modules="[Autoplay]"
        :autoplay="{ delay: 3000 }"
        :speed="1000"
        loop
    >
        <swiper-slide
            ><img
                class="w-full h-full object-cover object-center"
                :src="'/storage/heros/Sale.webp'"
                alt=""
        /></swiper-slide>
        <swiper-slide
            ><img :src="'/storage/heros/BanhMi.webp'" alt=""
        /></swiper-slide>
        <swiper-slide
            ><img :src="'/storage/heros/OtXiemXanh.webp'" alt=""
        /></swiper-slide>
        <swiper-slide
            ><img :src="'/storage/heros/RiceMilk.webp'" alt=""
        /></swiper-slide>
    </swiper>
</template>
<script setup>
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay } from "swiper/modules";
// Import Swiper styles
import "swiper/css";
</script>
<style scoped>
#app {
    height: 100%;
}
html,
body {
    position: relative;
    height: 100%;
}

body {
    background: #eee;
    font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
    font-size: 14px;
    color: #000;
    margin: 0;
    padding: 0;
}

.swiper {
    width: 100%;
    height: 100%;
}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;

    /* Center slide text vertically */
    display: flex;
    justify-content: center;
    align-items: center;
}

.swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
