<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
defineOptions({ layout: AdminLayout });
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
const props = defineProps({
    staffStatistics: Array,
    quantityStaff: Number,
    quantityOrders: Number,
});
const formatCurrency = (value) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
};

const selectedRange = ref("today");
const fetchData = () => {
    // console.log(selectedRange.value);
    router.get(
        route("admin.statistical.staff"),
        { timeFrame: selectedRange.value },
        {
            preserveScroll: true,
            preserveState: true,
        }
    );
};
// console.log(props.quantityOrders);
</script>

<template>
    <div class="min-h-screen bg-gradient-to-r from-blue-100 to-purple-200 p-8">
        <!-- Header -->
        <nav class="bg-white shadow-md p-4 mb-8 rounded-lg">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">
                    Thống Kê Nhân Viên
                </h1>
                <div>
                    <!-- Select filter thời gian -->
                    <select
                        v-model="selectedRange"
                        @change="fetchData"
                        class="bg-purple-500 text-white px-4 py-2 rounded-lg shadow focus:outline-none"
                    >
                        <option value="today">Hôm nay</option>
                        <option value="week">Tuần này</option>
                        <option value="month">Tháng này</option>
                        <option value="year">Năm nay</option>
                    </select>
                </div>
            </div>
        </nav>

        <!-- Overview Section -->
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-gray-700 mb-4">
                Tổng Quan Nhân Viên
            </h2>

            <!-- Cards thống kê -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Số lượng nhân viên -->
                <div
                    class="bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300"
                >
                    <div class="flex items-center justify-center">
                        <div
                            class="bg-gradient-to-r from-indigo-400 to-purple-500 text-white rounded-full p-5"
                        >
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-medium text-gray-500 mt-4">
                        Tổng số nhân viên
                    </h3>
                    <p class="text-4xl font-bold text-gray-800 mt-2">
                        {{ quantityStaff }}
                    </p>
                </div>

                <!-- Nhân viên xuất sắc nhất -->
                <div
                    class="bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300"
                >
                    <div class="flex items-center justify-center">
                        <div
                            class="bg-gradient-to-r from-green-400 to-blue-500 text-white rounded-full p-5"
                        >
                            <i class="fas fa-star text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-medium text-gray-500 mt-4">
                        Nhân viên xuất sắc nhất
                    </h3>
                    <p class="text-4xl font-bold text-gray-800 mt-2">
                        {{
                            staffStatistics[0]
                                ? staffStatistics[0].name
                                : "Chưa có đơn hôm nay"
                        }}
                    </p>
                    <p class="text-sm text-gray-500">
                        Doanh thu:
                        {{
                            staffStatistics[0]
                                ? formatCurrency(
                                      staffStatistics[0].total_revenue
                                  )
                                : "0 đ"
                        }}
                    </p>
                </div>

                <!-- Số đơn hàng từ nhân viên -->
                <div
                    class="bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300"
                >
                    <div class="flex items-center justify-center">
                        <div
                            class="bg-gradient-to-r from-red-400 to-pink-500 text-white rounded-full p-5"
                        >
                            <i class="fas fa-shopping-cart text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-medium text-gray-500 mt-4">
                        Số đơn hàng
                    </h3>
                    <p class="text-4xl font-bold text-gray-800 mt-2">
                        {{ quantityOrders }}
                    </p>
                </div>
            </div>

            <!-- Danh sách nhân viên -->
            <div class="mt-10">
                <h2 class="text-2xl font-bold text-gray-700 mb-4">
                    Danh sách Nhân Viên
                </h2>
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-600">
                                    Tên nhân viên
                                </th>
                                <th class="px-4 py-2 text-right text-gray-600">
                                    Số đơn hàng
                                </th>
                                <th class="px-4 py-2 text-right text-gray-600">
                                    Doanh thu
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="staffStatistics.length > 0">
                            <tr
                                class="border-b"
                                v-for="(staff, index) in staffStatistics"
                                :key="index"
                            >
                                <td class="px-4 py-2 text-gray-800">
                                    {{ staff.name }}
                                </td>
                                <td class="px-4 py-2 text-right text-gray-800">
                                    {{ staff.count_orders }}
                                </td>
                                <td class="px-4 py-2 text-right text-green-600">
                                    {{ formatCurrency(staff.total_revenue) }}
                                </td>
                            </tr>
                        </tbody>
                        <h5 v-else class="text-red-500 py-2 text-lg">
                            Chưa có nhân viên giao hàng hôm nay
                        </h5>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
