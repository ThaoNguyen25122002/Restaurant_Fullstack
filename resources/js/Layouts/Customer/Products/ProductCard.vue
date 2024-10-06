<script setup>
import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
defineProps({
    product: Object,
});
const formatCurrency = (value) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
};
// console.log(456);

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
// const addToCart = (product) => {
//     console.log(product);
//     // Gọi route với tham số product (giả sử product là một object với id)
//     router.post(route("cart.store", { product: product }), product, {
//         onSuccess: (page) => {
//             console.log("success");
//         },
//     });
// };
const formatNumber = (value) => {
    const numberValue = parseFloat(value);

    // Kiểm tra nếu phần thập phân bằng 0, làm tròn thành số nguyên
    if (Number.isInteger(numberValue)) {
        return Math.round(numberValue);
    }
    // Nếu phần thập phân khác 0, làm tròn đến 1 chữ số thập phân
    return numberValue.toFixed(1);
};
</script>

<template>
    <div class="p-2 bg-white shadow-lg rounded-lg flex flex-col h-full">
        <div class="overflow-hidden w-full rounded-md relative">
            <Link :href="route('food.detail', { slug: product.slug })">
                <img
                    class="w-full object-cover transition-transform duration-700 ease-in-out hover:scale-110"
                    :src="'/storage/' + product.image_url"
                    alt="Ưu Đãi"
                />
            </Link>
            <p
                v-if="product.quantity <= 0"
                class="absolute font-medium text-white top-1 right-1 px-2 rounded-xl bg-rose-600 pt-[2px]"
            >
                Hết Món
            </p>
        </div>
        <div class="flex-grow pt-3 pb-2 px-3 flex flex-col justify-between">
            <div>
                <div
                    class="flex items-start justify-between text-lg font-semibold text-gray-800"
                >
                    <h6 class="w-40">
                        <Link
                            :href="route('food.detail', { slug: product.slug })"
                        >
                            {{ product.product_name }}
                        </Link>
                    </h6>
                    <p class="text-orange-500">
                        {{ formatCurrency(product.price) }}
                    </p>
                </div>
                <p class="text-gray-600 text-sm mt-1">
                    {{ product.description }}
                </p>
            </div>

            <div class="flex items-center justify-between mt-3">
                <div>
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
                        Đã bán {{ product.sold_quantity }}
                    </p>
                </div>

                <button
                    @click="addToCart(product)"
                    :disabled="product.quantity === 0"
                    class="disabled:opacity-50 disabled:cursor-not-allowed bg-red-400 text-white text-xs py-2 px-4 rounded-md uppercase hover:bg-red-600 transition"
                >
                    Thêm vào giỏ
                </button>
            </div>
        </div>
    </div>
</template>
