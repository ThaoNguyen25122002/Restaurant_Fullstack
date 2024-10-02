<script setup>
import ProductList from "../../../Layouts/Customer/Products/ProductList.vue";
import CustomerLayout from "../../../Layouts/Customer/CustomerLayout.vue";
defineOptions({
    layout: CustomerLayout,
});
const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
});

console.log(props.categories);
</script>

<template>
    <div class="min-h-screen mt-[90px]">
        <h3 class="text-4xl font-medium uppercase pt-8 text-center text-black">
            Thực Đơn
        </h3>
        <ProductList
            v-for="category in categories"
            :key="category.id"
            :products="category.products"
            :title="category.category_name"
        />
    </div>
</template>
