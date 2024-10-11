<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";

import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
defineOptions({
    layout: AdminLayout,
});

defineProps({
    coupons: Array,
});
const handleRemove = (couponId) => {
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
            router.delete(route("admin.coupons.delete", { id: couponId }), {
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
                // onError: (errors) => {
                //     Swal.fire({
                //         title: "Error!",
                //         text: errors.error,
                //         icon: "error",
                //     });
                // },
            });
        }
    });
};
</script>

<template>
    <div class="min-h-screen bg-gray-100 p-2">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-700">
                Quản Lý Mã Giảm Giá
            </h2>
            <Link
                :href="route('admin.coupons.create')"
                class="bg-gradient-to-r from-green-400 to-teal-500 text-white px-6 py-2 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300"
            >
                Tạo Mã Giảm Giá
            </Link>
        </div>

        <!-- Table of Discount Codes -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-4 py-2 text-left text-gray-600 font-medium"
                        >
                            Mã Giảm Giá
                        </th>
                        <th
                            class="px-4 py-2 text-left text-gray-600 font-medium"
                        >
                            Phần Trăm Giảm
                        </th>
                        <th
                            class="px-4 py-2 text-left text-gray-600 font-medium"
                        >
                            Số Lượng
                        </th>
                        <th
                            class="px-4 py-2 text-left text-gray-600 font-medium"
                        >
                            Đã Sử Dụng
                        </th>
                        <th
                            class="px-4 py-2 text-left text-gray-600 font-medium"
                        >
                            Ngày Bắt Đầu
                        </th>
                        <th
                            class="px-4 py-2 text-left text-gray-600 font-medium"
                        >
                            Ngày Hết Hạn
                        </th>
                        <th
                            class="px-4 py-2 text-right text-gray-600 font-medium"
                        >
                            Thao Tác
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample Discount Code Row -->
                    <tr
                        class="border-b hover:bg-gray-50 transition-all"
                        v-for="coupon in coupons"
                        :key="coupon.id"
                    >
                        <td class="px-4 py-3 text-gray-700 font-medium">
                            {{ coupon.code }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ coupon.discount_percentage }}%
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ coupon.quantity }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ coupon.used_quantity }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ coupon.start_date }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ coupon.end_date }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button
                                @click="handleRemove(coupon.id)"
                                class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition-all"
                            >
                                Xóa
                            </button>
                        </td>
                    </tr>

                    <!-- Add more discount rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</template>
