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

Chart.register(
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Title,
    Tooltip
);

const props = defineProps({
    revenueData: Array,
    orderCount: Number,
    revenue: String,
    dishCount: Number,
    customerCount: Number,
    recentOrders: Array,
});
const currentYear = new Date().getFullYear();

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
    <div class="min-h-screen bg-gray-100">
        <!-- Phần nội dung chính của Dashboard -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Thẻ Tổng Quan -->
            <div
                class="col-span-1 lg:col-span-3 grid grid-cols-1 md:grid-cols-4 gap-4"
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
                            {{ orderCount }}
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
                            {{ formatCurrency(revenue) }}
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
                            {{ dishCount }}
                        </p>
                    </div>
                </div>
                <!-- Số lượng khách hàng -->
                <div
                    class="bg-white p-6 rounded-lg shadow-md flex items-center"
                >
                    <div class="p-4 bg-red-100 rounded-full mr-4 text-3xl">
                        👥
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-700">
                            Khách hàng
                        </h3>
                        <p class="text-2xl text-gray-800 font-semibold">
                            {{ customerCount }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ doanh thu và đơn hàng -->
            <div class="col-span-1 lg:col-span-2">
                <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">
                        Biểu đồ doanh thu {{ currentYear }}
                    </h3>
                    <div>
                        <!-- Placeholder for chart -->
                        <!-- <div class="h-64 bg-gray-200 rounded-lg"></div> -->
                        <div>
                            <canvas id="myChart"></canvas>
                        </div>
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
                                        Khách hàng:
                                        {{ order.customer.name }}
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
