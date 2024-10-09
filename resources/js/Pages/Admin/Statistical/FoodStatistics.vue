<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
defineOptions({ layout: AdminLayout });

defineProps({
    bestSellingFood: Object,
    leastSellingFood: Object,
    topSelling: Array,
    sumQuantity: String,
    topRating: Object,
    lowestRating: Object,
});
const formatCurrency = (value) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
};
const formatNumber = (value) => {
    const numberValue = parseFloat(value);

    if (Number.isInteger(numberValue)) {
        return Math.round(numberValue);
    }
    return numberValue.toFixed(1);
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
                <!-- <div>
                    <select
                        class="bg-yellow-500 text-white px-4 py-2 rounded-md shadow focus:outline-none"
                    >
                        <option value="day">Theo ngày</option>
                        <option value="week">Theo tuần</option>
                        <option value="month">Theo tháng</option>
                        <option value="year">Theo năm</option>
                    </select>
                </div> -->
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
                            <p class="text-xl font-bold text-gray-800">
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
                            <p class="text-xl font-bold text-gray-800">
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">
                        Món bán có đánh giá tốt nhất
                    </h3>
                    <p class="text-xl text-green-600">
                        {{ topRating.product_name }}
                    </p>
                    <div class="flex items-center gap-1">
                        <p class="text-lg text-gray-500">Đánh giá :</p>
                        <div class="flex items-center">
                            <svg
                                class="size-5 text-yellow-500 transform translate-y-[-2px]"
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
                            <span class="text-gray-500">{{
                                formatNumber(topRating.average_rating) +
                                " ( " +
                                topRating.count_rating +
                                " lược đánh giá )"
                            }}</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">
                        Món có đánh giá tệ nhất
                    </h3>
                    <p class="text-xl text-red-600">
                        {{ lowestRating.product_name }}
                    </p>
                    <div class="flex items-center gap-1">
                        <p class="text-lg text-gray-500">Đánh giá :</p>
                        <div class="flex items-center">
                            <svg
                                class="size-5 text-yellow-500 transform translate-y-[-2px]"
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
                            <span class="text-gray-500">{{
                                formatNumber(lowestRating.average_rating) +
                                " ( " +
                                lowestRating.count_rating +
                                " lược đánh giá )"
                            }}</span>
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
