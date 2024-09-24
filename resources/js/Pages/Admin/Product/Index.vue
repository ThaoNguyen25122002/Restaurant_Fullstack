<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import Swal from "sweetalert2";
import ProductList from "./ProductList.vue";
import { ref } from "vue";
defineOptions({
    layout: AdminLayout,
});

defineProps({
    products: Object,
});
</script>
<template>
    <ProductList :products="products" />
</template>
