<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
defineOptions({ layout: AdminLayout });

defineProps({
    bestSellingFood: Object,
    leastSellingFood: Object,
    topSelling: Array,
    sumQuantity: Number,
});
const formatCurrency = (value) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
};
</script>

<template>
    <div class="min-h-screen p-6">
        <!-- Thanh điều hướng -->
        <nav class="bg-white shadow-md p-4 mb-6">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-800">
                    Doanh Thu Theo Món
                </h1>
                <div>
                    <!-- Select filter theo ngày, tuần, tháng, năm -->
                    <select
                        class="bg-yellow-500 text-white px-4 py-2 rounded-md shadow focus:outline-none"
                    >
                        <option value="day">Theo ngày</option>
                        <option value="week">Theo tuần</option>
                        <option value="month">Theo tháng</option>
                        <option value="year">Theo năm</option>
                    </select>
                </div>
            </div>
        </nav>

        <!-- Tiêu đề trang -->
        <div class="container mx-auto">
            <h2 class="text-3xl font-semibold text-gray-700 mb-4">Tổng quan</h2>

            <!-- Phần thống kê -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Món bán chạy nhất -->
                <div
                    class="bg-white shadow-lg rounded-lg p-6 hover:shadow-2xl transition-transform duration-300"
                >
                    <div class="flex items-center">
                        <div
                            class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-full p-4"
                        >
                            <i class="fas fa-trophy text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-500">
                                Món bán chạy nhất
                            </h3>
                            <p class="text-4xl font-bold text-gray-800">
                                {{ bestSellingFood.product_name }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Đã bán: {{ bestSellingFood.sold_quantity }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Món bán được ít nhất -->
                <div
                    class="bg-white shadow-lg rounded-lg p-6 hover:shadow-2xl transition-transform duration-300"
                >
                    <div class="flex items-center">
                        <div
                            class="bg-gradient-to-r from-red-400 to-red-600 text-white rounded-full p-4"
                        >
                            <i class="fas fa-chart-line text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-500">
                                Món bán ít nhất
                            </h3>
                            <p class="text-4xl font-bold text-gray-800">
                                {{ leastSellingFood.product_name }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Đã bán: {{ leastSellingFood.sold_quantity }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tổng doanh thu từ các món -->
                <div
                    class="bg-white shadow-lg rounded-lg p-6 hover:shadow-2xl transition-transform duration-300"
                >
                    <div class="flex items-center">
                        <div
                            class="bg-gradient-to-r from-green-400 to-green-600 text-white rounded-full p-4"
                        >
                            <i class="fas fa-dollar-sign text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-500">
                                Tổng số lượng đã bán
                            </h3>
                            <p class="text-4xl font-bold text-gray-800">
                                {{ sumQuantity }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách món có doanh thu cao nhất -->
            <div class="mt-10">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                    Danh sách món có doanh thu cao nhất
                </h2>
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-600">
                                    Tên món
                                </th>

                                <th class="px-4 py-2 text-right text-gray-600">
                                    Số lượng bán ra
                                </th>
                                <th class="px-4 py-2 text-right text-gray-600">
                                    Doanh thu
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="border-b"
                                v-for="food in topSelling"
                                :key="food.id"
                            >
                                <td class="px-4 py-2 text-gray-800">
                                    {{ food.product_name }}
                                </td>

                                <td class="px-4 py-2 text-right text-gray-800">
                                    {{ food.sold_quantity }}
                                </td>
                                <td class="px-4 py-2 text-right text-green-600">
                                    {{
                                        formatCurrency(
                                            food.sold_quantity * food.price
                                        )
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
