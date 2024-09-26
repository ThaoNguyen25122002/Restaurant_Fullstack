<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import PaginationLinks from "@/components/Common/PaginationLinks.vue";
defineOptions({
    layout: AdminLayout,
});
defineProps({
    categories: Object,
    searchTerm: String,
});

import CategoryList from "./CategoryList.vue";
</script>

<template>
    <CategoryList :categories="categories.data" :searchTerm="searchTerm" />
    <PaginationLinks :paginator="categories" />
</template>
