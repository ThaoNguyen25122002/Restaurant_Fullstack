<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import UserList from "./UserList.vue";
import PaginationLinks from "../../../components/Common/PaginationLinks.vue";
defineOptions({
    layout: AdminLayout,
});
defineProps({
    roles: Array,
    users: Object,
    searchTerm: String,
});
</script>

<template>
    <UserList :users="users" :roles="roles" :searchTerm="searchTerm" />
    <pagination-links :paginator="users" />
</template>
