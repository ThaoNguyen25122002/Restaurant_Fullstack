<script setup>
import ProductList from "../../../Layouts/Customer/Products/ProductList.vue";
import CustomerLayout from "../../../Layouts/Customer/CustomerLayout.vue";
defineOptions({
    layout: CustomerLayout,
});

const props = defineProps({
    products: Object,
    category_name: String,
});
console.log(props.category_name);
</script>

<template>
    <div class="mt-[72px] mb-[72px]">
        <ProductList :products="products" :title="category_name" />
    </div>
</template>
