<script setup>
import { onMounted, ref } from "vue";
import {
    Chart,
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Title,
    Tooltip,
} from "chart.js"; // Import đúng thành phần
import { router } from "@inertiajs/vue3";
Chart.register(
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Title,
    Tooltip
);
const selectedRange = ref("today");
const props = defineProps({
    revenueData: Array,
    doanhThu: String,
    tongMonAn: String,
    tongDonHang: Number,
    tiLeThanhCong: Number,
    tiLeThatBai: Number,
    banChayNhat: Object,
    banItNhat: Object,
    recentOrders: Array,
});
const currentYear = new Date().getFullYear();
const fetchData = () => {
    // console.log(selectedRange.value);
    router.get(
        route("admin.dashboard"),
        { timeFrame: selectedRange.value },
        {
            preserveScroll: true,
            preserveState: true,
        }
    );
};
onMounted(() => {
    const labels = props.revenueData.map((item) => `Tháng ${item.month}`);
    const data = props.revenueData.map((item) => item.total);

    const ctx = document.getElementById("myChart").getContext("2d");
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels, // Tháng
            datasets: [
                {
                    label: "Doanh thu",
                    data: data, // Doanh thu theo tháng
                    backgroundColor: "rgba(54, 162, 235, 0.2)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
});
const formatCurrency = (value) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
};

import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
defineOptions({ layout: AdminLayout });
const toggle = ref(false);
</script>
<template>
    <div class="min-h-screen">
        <!-- Select time range -->
        <div class="mb-6">
            <label
                for="timeRange"
                class="block text-sm font-medium text-gray-700 mb-2"
            >
                Chọn mốc thời gian:
            </label>
            <select
                id="timeRange"
                v-model="selectedRange"
                @change="fetchData"
                class="block w-full p-2 border border-gray-300 rounded-md"
            >
                <option value="today">Hôm nay</option>
                <option value="week">Tuần này</option>
                <option value="month">Tháng này</option>
                <option value="year">Năm này</option>
            </select>
        </div>

        <!-- Phần nội dung chính của Dashboard -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Thẻ Tổng Quan -->
            <div
                class="col-span-1 lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4"
            >
                <!-- Tổng số đơn hàng -->
                <div
                    class="bg-white p-6 rounded-lg shadow-md flex items-center"
                >
                    <div class="p-4 bg-green-100 rounded-full mr-4 text-3xl">
                        📦
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-700">
                            Đơn hàng
                        </h3>
                        <p class="text-2xl text-gray-800 font-semibold">
                            {{ tongDonHang ? tongDonHang : 0 }}
                        </p>
                    </div>
                </div>

                <!-- Doanh thu -->
                <div
                    class="bg-white p-6 rounded-lg shadow-md flex items-center"
                >
                    <div class="p-4 bg-blue-100 rounded-full mr-4 text-3xl">
                        💰
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-700">
                            Doanh thu
                        </h3>
                        <p class="text-xl text-gray-800 font-semibold">
                            {{ doanhThu ? formatCurrency(doanhThu) : 0 }}
                        </p>
                    </div>
                </div>

                <!-- Số món đang bán -->
                <div
                    class="bg-white p-6 rounded-lg shadow-md flex items-center"
                >
                    <div class="p-4 bg-yellow-100 rounded-full mr-4 text-3xl">
                        🍽️
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-700">Món ăn</h3>
                        <p class="text-2xl text-gray-800 font-semibold">
                            {{ tongMonAn ? tongMonAn : 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Best-Selling, Least-Selling, Success, and Failure Rates -->
            <div
                class="col-span-1 lg:col-span-3 grid grid-cols-1 lg:grid-cols-4 gap-6"
            >
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">
                        Món bán chạy nhất
                    </h3>
                    <p class="text-xl text-green-600">
                        {{
                            banChayNhat
                                ? banChayNhat.product_name
                                : "Chưa có món được bán hôm nay"
                        }}
                    </p>
                    <p class="text-sm text-gray-500">
                        Số lượng bán:
                        {{ banChayNhat ? banChayNhat.total_quantity : 0 }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">
                        Món ít được ưa chuộng nhất
                    </h3>
                    <p class="text-xl text-red-600">
                        {{
                            banItNhat
                                ? banItNhat.product_name
                                : "Chưa có dữ liệu món bán hôm nay"
                        }}
                    </p>
                    <p class="text-sm text-gray-500">
                        Số lượng bán:
                        {{ banItNhat ? banItNhat.total_quantity : 0 }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">
                        Tỷ lệ đơn hàng thành công
                    </h3>
                    <p class="text-4xl font-bold text-green-500">
                        {{ tiLeThanhCong ? Math.round(tiLeThanhCong) : 0 }}%
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">
                        Tỷ lệ đơn hàng thất bại
                    </h3>
                    <p class="text-4xl font-bold text-red-500">
                        {{ tiLeThatBai ? Math.round(tiLeThatBai) : 0 }}%
                    </p>
                </div>
            </div>

            <!-- Biểu đồ doanh thu và đơn hàng gần đây -->
            <div class="col-span-1 lg:col-span-2">
                <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">
                        Biểu đồ doanh thu {{ currentYear }}
                    </h3>
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Danh sách đơn hàng gần đây -->
            <div class="col-span-1">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">
                        Đơn hàng gần đây
                    </h3>
                    <ul class="divide-y divide-gray-200">
                        <li
                            class="py-4"
                            v-for="order in recentOrders"
                            :key="order.id"
                        >
                            <div class="flex justify-between">
                                <div>
                                    <p class="font-semibold text-gray-700">
                                        Đơn hàng #{{ order.order_code }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Khách hàng: {{ order.customer.name }}
                                    </p>
                                </div>
                                <p class="text-gray-700">
                                    {{ formatCurrency(order.total_amount) }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- 
 -->
