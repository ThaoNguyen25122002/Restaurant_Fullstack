<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import ProductList from "./ProductList.vue";
import PaginationLinks from "../../../components/Common/PaginationLinks.vue";
defineOptions({
    layout: AdminLayout,
});

defineProps({
    products: Object,
    searchTerm: String,
});
// console.log(props.products);
</script>
<template>
    <!-- <div v-for="product in products" :key="product.id">
        <h1>{{ product.product_name }}</h1>
        <img :src="'/storage/' + product.image_url" alt="" />
    </div> -->
    <!-- <img src="/storage/products/1727163886_66f26deeb9ddd.png" alt="" /> -->
    <ProductList :products="products" :searchTerm="searchTerm" />
    <pagination-links :paginator="products" />
</template>
