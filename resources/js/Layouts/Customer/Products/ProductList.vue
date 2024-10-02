<script setup>
import ProductCard from "./ProductCard.vue";
const props = defineProps({
    title: String,
    products: {
        type: [Object, Array],
        required: true,
    },
});

console.log(props.products);
</script>

<template>
    <div class="container mb-5" v-if="products.length > 0">
        <div class="flex items-center pt-8 pb-7" v-if="title">
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
            <ProductCard
                v-for="product in products"
                :key="product.id"
                :product="product"
            />
            <!-- <ProductCard />
            <ProductCard />
            <ProductCard /> -->
        </div>
    </div>
</template>
