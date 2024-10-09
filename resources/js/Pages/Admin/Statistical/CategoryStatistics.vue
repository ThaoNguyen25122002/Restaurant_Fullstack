<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import { ref } from "vue";
defineOptions({ layout: AdminLayout });
import { router } from "@inertiajs/vue3";
defineProps({
    categoryData: Array,
    bestSellingCategory: Object,
    leastSellingCategory: Object,
    averageRevenue: Number,
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
        route("admin.statistical.categories"),
        { timeFrame: selectedRange.value },
        {
            preserveScroll: true,
            preserveState: true,
        }
    );
};
</script>

<template>
    <div class="min-h-screen p-6">
        <!-- Thanh điều hướng -->
        <nav class="bg-white shadow-md p-4 mb-6">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-800">
                    Thống Kê Danh Mục
                </h1>
                <div>
                    <!-- Select filter theo ngày, tuần, tháng, năm -->
                    <select
                        v-model="selectedRange"
                        @change="fetchData"
                        class="bg-red-400 text-white px-4 py-2 rounded-md shadow focus:outline-none"
                    >
                        <option value="today" class="bg-white text-black">
                            Hôm nay
                        </option>
                        <option value="week" class="bg-white text-black">
                            Theo tuần
                        </option>
                        <option value="month" class="bg-white text-black">
                            Theo tháng
                        </option>
                        <option value="year" class="bg-white text-black">
                            Theo năm
                        </option>
                    </select>
                </div>
            </div>
        </nav>

        <!-- Tiêu đề trang -->
        <div class="container mx-auto">
            <h2 class="text-3xl font-semibold text-gray-700 mb-4">Tổng quan</h2>

            <!-- Phần thống kê -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Danh mục bán chạy nhất -->
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
                                Danh mục bán chạy nhất
                            </h3>
                            <p class="text-xl font-bold text-gray-800">
                                {{
                                    bestSellingCategory
                                        ? bestSellingCategory.category_name
                                        : "0"
                                }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Danh mục bán được ít nhất -->
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
                                Danh mục bán ít nhất
                            </h3>
                            <p class="text-xl font-bold text-gray-800">
                                {{
                                    leastSellingCategory
                                        ? leastSellingCategory.category_name
                                        : "0"
                                }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Doanh thu trung bình theo từng danh mục -->
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
                                Doanh thu trung bình danh mục
                            </h3>
                            <p class="text-4xl font-bold text-gray-800">
                                {{ formatCurrency(averageRevenue) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách danh mục có doanh thu cao nhất -->
            <div class="mt-10">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                    Danh sách danh mục có doanh thu cao nhất
                </h2>
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-600">
                                    Tên danh mục
                                </th>
                                <th class="px-4 py-2 text-right text-gray-600">
                                    Số lượng
                                </th>
                                <th class="px-4 py-2 text-right text-gray-600">
                                    Doanh thu
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="border-b"
                                v-for="(item, index) in categoryData"
                                :key="index"
                            >
                                <td class="px-4 py-2 text-gray-800">
                                    {{ item.category_name }}
                                </td>
                                <td class="px-4 py-2 text-right text-gray-800">
                                    {{ item.total_sold }}
                                </td>
                                <td class="px-4 py-2 text-right text-green-600">
                                    {{ formatCurrency(item.total_revenue) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
