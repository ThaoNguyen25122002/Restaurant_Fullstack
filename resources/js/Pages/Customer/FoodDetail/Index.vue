<script setup>
import CustomerLayout from "../../../Layouts/Customer/CustomerLayout.vue";
defineOptions({
    layout: CustomerLayout,
});
import ProductList from "../../../Layouts/Customer/Products/ProductList.vue";
import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
const props = defineProps({
    product: Object,
    recommendProducts: Array,
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
};
const addToCart = (product) => {
    // console.log(product);
    router.post(
        route("cart.store", product),
        {},
        {
            preserveScroll: true,
            // progress: false,
            // onStart: () => NProgress.done(),
            onSuccess: (page) => {
                if (page.props.flash.success) {
                    Swal.fire({
                        toast: true,
                        icon: "success",
                        position: "top-end",
                        showConfirmButton: false,
                        title: page.props.flash.success,
                        timer: 1500,
                    });
                }
            },
            onError: (errors) => {
                // console.log(123);
                // console.log(page);

                Swal.fire({
                    toast: true,
                    icon: "warning",
                    position: "top-end",
                    showConfirmButton: false,
                    // title: errors.error,
                    text: errors.error,
                    timer: 1500,
                });
            },
        }
    );
};
console.log(props.product);
</script>

<template>
    <div
        class="bg-gray-100 min-h-screen flex flex-col items-center justify-center py-10 px-4"
    >
        <!-- Container -->
        <div
            class="w-full min-h-screen lg:max-w-7xl bg-white rounded-lg shadow-lg overflow-hidden mt-[42px]"
        >
            <!-- Main Content -->
            <div class="md:flex">
                <!-- Image Section -->
                <div class="md:w-1/2">
                    <img
                        :src="'/storage/' + product.image_url"
                        alt="Fried Chicken"
                        class="w-full h-full object-cover"
                    />
                </div>
                <!-- Food Details Section -->
                <div
                    class="md:w-1/2 p-6 sm:p-8 md:flex md:flex-col md:justify-center"
                >
                    <!-- Food Name -->
                    <h2 class="text-3xl font-bold text-red-600 mb-4">
                        {{ product.product_name }}
                    </h2>

                    <!-- Price -->
                    <p class="text-xl text-gray-700 font-semibold mb-4">
                        {{ formatCurrency(product.price) }}
                    </p>

                    <!-- Description -->
                    <p class="text-gray-600 leading-relaxed mb-6">
                        {{ product.description }}
                    </p>

                    <!-- Quantity & Size -->
                    <div class="mb-6">
                        <div class="flex items-center gap-x-1 text-base">
                            <p class="text-gray-700">Số lượng:</p>
                            <p class="text-gray-500">
                                {{
                                    product.quantity === 0
                                        ? "Hết món"
                                        : product.quantity
                                }}
                            </p>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="flex items-center gap-x-1 text-base">
                            <p class="text-gray-700">Đã bán:</p>
                            <p class="text-gray-500">
                                {{ product.sold_quantity }}
                            </p>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <button
                        @click="addToCart(product)"
                        type="button"
                        :disabled="product.quantity === 0"
                        class="disabled:opacity-50 disabled:cursor-not-allowed w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-400"
                    >
                        Thêm vào giỏ
                    </button>
                </div>
            </div>

            <!-- Recommended Section -->
            <ProductList
                :products="recommendProducts"
                title="Các món liên quan"
            />
        </div>
    </div>
</template>
