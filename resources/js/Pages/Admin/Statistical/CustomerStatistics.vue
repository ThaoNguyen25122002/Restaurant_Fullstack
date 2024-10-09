<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
defineOptions({ layout: AdminLayout });
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
import { onMounted } from "vue";
Chart.register(
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Title,
    Tooltip
);
const props = defineProps({
    soLuongKhachHang: Number,
    doanhThuTrungBinhCuaMoiKhachHang: Number,
    soLuongDonTheoTrungBinhCuaKhachHang: Number,
    danhSachKhachCoDoanhThuCaoNhat: Array,
    newCustomers: Array,
});
const formatCurrency = (value) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
};
const currentYear = new Date().getFullYear();
onMounted(() => {
    console.log(props.newCustomers);

    const labels = props.newCustomers.map((item) => `Tháng ${item.month}`);
    const data = props.newCustomers.map((item) => item.total);

    const ctx = document.getElementById("myChart").getContext("2d");
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels, // Tháng
            datasets: [
                {
                    label: "Khách hàng mới",
                    data: data, // Khách hàng mới theo tháng
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
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
</script>

<template>
    <div class="min-h-screen p-6">
        <!-- Thanh điều hướng -->
        <nav class="bg-white shadow-md p-4 mb-6">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-800">
                    Thống Kê Khách Hàng
                </h1>
            </div>
        </nav>

        <!-- Tiêu đề trang -->
        <div class="container mx-auto">
            <h2 class="text-3xl font-semibold text-gray-700 mb-4">Tổng quan</h2>

            <!-- Phần thống kê -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Số lượng khách hàng -->
                <div
                    class="bg-white shadow-lg rounded-lg p-6 hover:shadow-2xl transition-transform duration-300"
                >
                    <div class="flex items-center">
                        <div
                            class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-full p-4"
                        >
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-500">
                                Số lượng khách hàng
                            </h3>
                            <p class="text-4xl font-bold text-gray-800">
                                {{ soLuongKhachHang }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Doanh thu từ mỗi khách hàng -->
                <div
                    class="bg-white shadow-lg rounded-lg p-6 hover:shadow-2xl transition-transform duration-300"
                >
                    <div class="flex items-center">
                        <div
                            class="bg-gradient-to-r from-blue-400 to-blue-600 text-white rounded-full p-4"
                        >
                            <i class="fas fa-shopping-cart text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-500">
                                Doanh thu từ mỗi khách hàng
                            </h3>
                            <p class="text-4xl font-bold text-gray-800">
                                {{
                                    formatCurrency(
                                        doanhThuTrungBinhCuaMoiKhachHang
                                    )
                                }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Đơn trung bình của mỗi khách -->
                <div
                    class="bg-white shadow-lg rounded-lg p-6 hover:shadow-2xl transition-transform duration-300"
                >
                    <div class="flex items-center">
                        <div
                            class="bg-gradient-to-r from-teal-400 to-teal-600 text-white rounded-full p-4"
                        >
                            <i class="fas fa-box text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-500">
                                Đơn trung bình của mỗi khách
                            </h3>
                            <p class="text-4xl font-bold text-gray-800">
                                {{ soLuongDonTheoTrungBinhCuaKhachHang }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách khách hàng có doanh thu cao nhất -->
            <div class="mt-10">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                    Khách hàng có doanh thu cao nhất
                </h2>
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-600">
                                    Tên khách hàng
                                </th>
                                <th class="px-4 py-2 text-right text-gray-600">
                                    Doanh thu
                                </th>
                                <th class="px-4 py-2 text-right text-gray-600">
                                    Số đơn hàng
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="border-b"
                                v-for="(
                                    item, index
                                ) in danhSachKhachCoDoanhThuCaoNhat"
                                :key="index"
                            >
                                <td class="px-4 py-2 text-gray-800">
                                    {{ item.name }}
                                </td>
                                <td class="px-4 py-2 text-right text-green-600">
                                    {{ formatCurrency(item.total_revenue) }}
                                </td>
                                <td class="px-4 py-2 text-right text-gray-800">
                                    {{ item.total_orders }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Biểu đồ hoặc thông tin chi tiết khác -->
            <div class="col-span-1 lg:col-span-2 mt-10">
                <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">
                        Biểu đồ khách hàng mới năm {{ currentYear }}
                    </h3>
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
