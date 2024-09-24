<script setup>
import HeaderView from "./HeaderView.vue";
import MenuView from "./MenuView.vue";
import { ref } from "vue";
// const count = ref;
// const ref
const toggle = ref(false);
</script>

<template>
    <!-- Header -->
    <!-- <Header /> -->
    <HeaderView />
    <!-- End Header -->
    <!-- Menu -->
    <MenuView />
    <!-- End Menu -->
    <!-- Body -->
    <div class="p-4 sm:ml-64 mt-[64px]">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg">
            <slot />
        </div>
    </div>

    <!-- End Body  -->
</template>
