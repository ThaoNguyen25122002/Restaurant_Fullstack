<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
defineOptions({
    layout: AdminLayout,
});
const props = defineProps({
    categories: Array,
});
import CategoryList from "./CategoryList.vue";
</script>

<template>
    <CategoryList :categories="categories" />
</template>
