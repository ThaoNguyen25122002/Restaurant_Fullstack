<script setup>
import ProductCard from "./ProductCard.vue";
defineProps({
    title: String,
});
</script>

<template>
    <div class="container">
        <div class="flex items-center pt-12 pb-7">
            <h4
                class="font-extrabold text-xl sm:text-2xl whitespace-nowrap pr-4 text-[#202124] tracking-wide uppercase"
            >
                {{ title }}
            </h4>
            <span
                class="border w-full bg-gray-200 text-gray-100 h-[2px]"
            ></span>
        </div>

        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4"
        >
            <ProductCard />
            <ProductCard />
            <ProductCard />
            <ProductCard />
        </div>
    </div>
</template>
