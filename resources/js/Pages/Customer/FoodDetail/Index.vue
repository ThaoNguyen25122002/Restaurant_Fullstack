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
    reviews: Array,
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
const formatNumber = (value) => {
    const numberValue = parseFloat(value);

    // Kiểm tra nếu phần thập phân bằng 0, làm tròn thành số nguyên
    if (Number.isInteger(numberValue)) {
        return Math.round(numberValue);
    }
    // Nếu phần thập phân khác 0, làm tròn đến 1 chữ số thập phân
    return numberValue.toFixed(1);
};
// console.log(props.product);
const formatDate = (dateString) => {
    const options = { year: "numeric", month: "long", day: "numeric" };
    return new Date(dateString).toLocaleDateString(undefined, options);
};
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
                    <div class="flex items-center gap-2 mb-6">
                        <div
                            class="flex text-sm items-end"
                            v-if="product.average_rating > 0"
                        >
                            <svg
                                class="size-5 text-yellow-500"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
                                />
                            </svg>
                            <span class="transform translate-y-[2px]">
                                {{ formatNumber(product.average_rating) }}
                            </span>
                        </div>
                        <p v-else class="text-sm">(Chưa có đánh giá)</p>
                        <p class="text-sm text-gray-500 mt-1">
                            Đã bán | {{ product.sold_quantity }}
                        </p>
                    </div>
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
                        <!-- <div class="flex items-center gap-x-1 text-base">
                            <p class="text-gray-700">Đã bán:</p>
                            <p class="text-gray-500">
                                {{ product.sold_quantity }}
                            </p>
                        </div> -->
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
            <!-- Hiển thị danh sách các review mới nhất -->
            <!-- Tiêu đề Đánh giá sản phẩm -->
            <div class="bg-white rounded-lg p-6 mb-8">
                <h2
                    class="text-2xl font-bold text-gray-800 mb-6 border-b-2 pb-4"
                >
                    Đánh giá sản phẩm
                </h2>

                <!-- Kiểm tra nếu có đánh giá -->
                <div v-if="reviews.length > 0">
                    <!-- Lặp qua các review -->
                    <div
                        v-for="review in reviews"
                        :key="review.id"
                        class="review-item p-4 mb-6 bg-gray-50 rounded-lg shadow-sm"
                    >
                        <!-- Thông tin người dùng và đánh giá -->
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <!-- Ảnh đại diện người dùng giả lập -->
                                <div
                                    class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center"
                                >
                                    <span class="text-white text-lg font-bold">
                                        {{
                                            review.user.name
                                                .charAt(0)
                                                .toUpperCase()
                                        }}
                                    </span>
                                </div>
                                <!-- Tên người dùng và ngày đánh giá -->
                                <div>
                                    <p class="font-semibold text-gray-700">
                                        {{ review.user.name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ formatDate(review.created_at) }}
                                    </p>
                                </div>
                            </div>
                            <!-- Điểm đánh giá -->
                            <div
                                class="flex items-center gap-1 text-yellow-500"
                            >
                                <svg
                                    v-for="i in 5"
                                    :key="i"
                                    :class="{
                                        'fill-current': i <= review.rating,
                                        'text-gray-300': i > review.rating,
                                    }"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="20"
                                    height="20"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
                                    />
                                </svg>
                            </div>
                        </div>

                        <!-- Nội dung đánh giá -->
                        <p class="text-gray-600 leading-relaxed">
                            {{ review.review }}
                        </p>
                    </div>
                </div>

                <!-- Thông báo nếu chưa có đánh giá -->
                <p v-else class="text-gray-500 text-center mt-6">
                    Chưa có đánh giá nào cho sản phẩm này.
                </p>
            </div>

            <!-- Recommended Section -->
            <ProductList
                :products="recommendProducts"
                title="Các món liên quan"
            />
        </div>
    </div>
</template>
