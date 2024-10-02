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
                v-if="product.quantity === 0"
                class="absolute font-medium text-white top-1 left-1 px-2 rounded-xl bg-rose-600 pt-[2px]"
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
                <p class="text-sm text-gray-500">
                    Đã bán {{ product.sold_quantity }}
                </p>
                <button
                    @click="addToCart(product)"
                    :disabled="product.quantity === 0"
                    class="disabled:opacity-50 disabled:cursor-not-allowed bg-red-400 text-white text-xs py-1 px-3 rounded-md uppercase hover:bg-red-600 transition"
                >
                    Thêm vào giỏ
                </button>
            </div>
        </div>
    </div>
</template>
