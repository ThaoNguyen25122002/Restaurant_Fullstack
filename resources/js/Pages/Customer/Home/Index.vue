<script setup>
// import Navbar from "../../../Layouts/Customer/Navbar.vue";
// import Footer from "../../../Layouts/Customer/Footer.vue";
import HeroBanner from "./HeroBanner.vue";
import CustomerLayout from "../../../Layouts/Customer/CustomerLayout.vue";
import DishList from "./DishList.vue";
import ProductList from "../../../Layouts/Customer/Products/ProductList.vue";
defineOptions({
    layout: CustomerLayout,
});

defineProps({
    products: Array,
    categories: Array,
});
</script>

<template>
    <!-- Delivery -->
    <div
        class="bg-[#202124] text-white py-4 w-full flex justify-center mt-[72px]"
    >
        <div class="text-center flex justify-between items-center px-4">
            <!-- Navigation Links -->
            <div class="flex space-x-8">
                <a href="#" class="flex items-center hover:text-yellow-400">
                    <span>Đặt Ngay</span>
                </a>
                <a href="#" class="flex items-center hover:text-yellow-400">
                    <img
                        :src="'/storage/Logo/asdasd.png'"
                        alt="Giao Hàng"
                        class="h-6 mr-1"
                    />
                    <span>Giao Hàng</span>
                </a>
                <a href="#" class="flex items-center hover:text-yellow-400">
                    <img
                        :src="'/storage/Logo/asdasd.png'"
                        alt="Mang Đi"
                        class="h-6 mr-1"
                    />
                    <span>Mang Đi</span>
                </a>
            </div>

            <!-- Order Button -->
        </div>
    </div>
    <!-- Hero Banner -->
    <HeroBanner />

    <!-- Dish List -->
    <DishList :categories="categories" />

    <!-- Product List -->
    <ProductList :products="products" title="Có thể bạn sẽ thích món này" />
</template>
