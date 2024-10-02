<script setup>
import ProductList from "../../../Layouts/Customer/Products/ProductList.vue";
import CustomerLayout from "../../../Layouts/Customer/CustomerLayout.vue";
defineOptions({
    layout: CustomerLayout,
});
const props = defineProps({
    products: {
        type: Array,
        required: true,
    },
    searchTerm: String,
});

console.log(props.products);
</script>

<template>
    <div class="mt-[72px] min-h-screen">
        <div class="text-center py-5">
            <h5 class="text-xl">
                Tìm thấy
                <span class="text-red-400">{{ products.length }}</span> kết quả
                cho '<span class="text-red-400">{{ searchTerm }}</span
                >'
            </h5>
        </div>
        <ProductList :products="products" />
    </div>
</template>
