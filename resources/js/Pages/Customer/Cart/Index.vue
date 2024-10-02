<script setup>
import CustomerLayout from "../../../Layouts/Customer/CustomerLayout.vue";
import Swal from "sweetalert2";
import { router, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
const page = usePage();
const props = defineProps({
    carts: Array,
});

// const products = computed(() => usePage().props.cart);
const handleCheckout = () => {
    if (!page.props.auth.user.address || !page.props.auth.user.phone) {
        Swal.fire({
            toast: true,
            icon: "warning",
            position: "top-end",
            showConfirmButton: false,
            text: "Vui lòng cập nhật đầy đủ sdt và địa chỉ.",
            timer: 2000,
        });
        return;
    }
    router.get(
        route("checkout"),
        {},
        {
            onError: (errors) => {
                Swal.fire({
                    toast: true,
                    icon: "warning",
                    position: "top-end",
                    showConfirmButton: false,
                    text: errors[0],
                    timer: 2000,
                });
            },
        }
    );
};
const formatCurrency = (value) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
};
defineOptions({
    layout: CustomerLayout,
});

const updateQuantity = (product, quantity) => {
    router.patch(route("cart.update", { id: product.id }), { quantity });
};
const removeItem = (id) => {
    // router.delete(route("cart.delete", { id }));
    Swal.fire({
        title: "Bạn muốn xóa?",
        // text: "Bạn không thể khôi phục nếu xóa!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Xóa!",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route("cart.delete", { id }), {
                onSuccess: (page) => {
                    Swal.fire({
                        toast: true,
                        icon: "success",
                        position: "top-end",
                        showConfirmButton: false,
                        title: page.props.flash.success,
                        timer: 1500,
                    });
                },
            });
        }
    });
};

const totalPrice = computed(() => {
    return props.carts.reduce(
        (total, item) => total + item.quantity * item.product.price,
        0
    );
});
</script>

<template>
    <div
        v-if="$page.props.cartTotalItems > 0"
        class="container w-full mx-auto mt-10 p-10 bg-white shadow-2xl rounded-lg"
    >
        <!-- Bảng giỏ hàng -->
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-red-300 text-white">
                <tr>
                    <th class="py-4 px-4 text-left font-semibold">Ảnh</th>
                    <th class="py-4 px-4 text-left font-semibold">Sản Phẩm</th>
                    <th class="py-4 px-4 text-right font-semibold">Giá</th>
                    <th class="py-4 px-4 text-center font-semibold">
                        Số Lượng
                    </th>
                    <th class="py-4 px-4 text-right font-semibold">
                        Thành Tiền
                    </th>
                    <th class="py-4 px-4 text-center font-semibold">Xóa</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in carts" :key="item.id" class="border-t">
                    <td class="py-4">
                        <img
                            :src="'storage/' + item.product.image_url"
                            alt="product image"
                            class="w-20 h-20 object-cover rounded-lg mx-auto border border-gray-300"
                        />
                    </td>
                    <td class="py-4 px-4 text-gray-800 font-medium">
                        <div>{{ item.product.product_name }}</div>
                        <div class="text-gray-500 text-sm">Màu sắc:</div>
                        <div class="text-gray-500 text-sm">Kích thước:</div>
                    </td>
                    <td class="py-4 px-4 text-right text-gray-800">
                        {{ formatCurrency(item.product.price) }}
                    </td>
                    <td class="py-4 px-4 text-center">
                        <button
                            :disabled="item.quantity === 1"
                            @click="updateQuantity(item, item.quantity - 1)"
                            class="px-3 py-1 bg-red-300 text-white rounded-md hover:bg-opacity-90"
                        >
                            &minus;
                        </button>
                        <span class="mx-4 font-semibold text-gray-800">{{
                            item.quantity
                        }}</span>
                        <button
                            @click="updateQuantity(item, item.quantity + 1)"
                            :disabled="item.quantity === item.product.quantity"
                            class="px-3 py-1 bg-red-300 text-white rounded-md hover:bg-opacity-90"
                        >
                            &#43;
                        </button>
                    </td>
                    <td
                        class="py-4 px-4 text-right text-gray-800 font-semibold"
                    >
                        {{ formatCurrency(item.product.price * item.quantity) }}
                    </td>
                    <td class="py-4 px-4 text-center">
                        <button
                            @click="removeItem(item.id)"
                            class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600"
                        >
                            &#10005;
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Phần áp dụng coupon và tổng tiền -->
        <div class="mt-10 max-w-[400px] gap-8 ml-auto">
            <div class="md:col-span-1 bg-gray-50 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700">Đơn Hàng</h2>

                <div class="flex justify-between mt-4 border-t pt-4">
                    <span class="text-gray-700 font-semibold"
                        >Tổng giá trị đơn:</span
                    >
                    <span class="text-gray-900 font-bold">{{
                        formatCurrency(totalPrice)
                    }}</span>
                </div>
                <button
                    @click="handleCheckout"
                    class="w-full mt-6 px-6 py-2 bg-red-400 text-white rounded-lg hover:bg-opacity-90"
                >
                    Đặt hàng
                </button>
            </div>
        </div>
    </div>
    <div v-else class="py-[300px]">
        <h4 class="text-red-500 font-semibold text-2xl text-center">
            Giỏ hàng rỗng!!!
        </h4>
    </div>
</template>
