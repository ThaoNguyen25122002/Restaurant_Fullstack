<script setup>
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
defineOptions({ layout: AdminLayout });

const props = defineProps({
    // tongDon: Number,
    doanhThu: String,
    tongMonAn: String,
    tongDonHang: Number,
    tiLeThanhCong: Number,
    tiLeThatBai: Number,
    banChayNhat: Object,
    banItNhat: Object,
});
// Selected time range
const selectedRange = ref("today");
const fetchData = () => {
    // console.log(selectedRange.value);
    router.get(
        route("admin.statistical"),
        { timeFrame: selectedRange.value },
        {
            preserveScroll: true,
            preserveState: true,
        }
    );
};
// Function to format currency
const formatCurrency = (value) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
};
</script>

<template>
    <div class="min-h-screen bg-white">
        <!-- Header -->
        <header class="py-4 rounded-lg">
            <h1 class="text-2xl font-bold text-gray-700">Trang thống kê</h1>
        </header>

        <!-- Select time range -->
        <div class="mb-6">
            <label
                for="timeRange"
                class="block text-sm font-medium text-gray-700 mb-2"
                >Chọn khoảng thời gian:</label
            >
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

        <!-- Statistics Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <!-- Orders Count -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700">Đơn hàng</h2>
                <p class="text-4xl font-bold text-yellow-500 mt-2">
                    {{ tongDonHang ? tongDonHang : 0 }}
                </p>
                <!-- <span class="text-sm text-gray-500">{{ timeDescription }}</span> -->
            </div>

            <!-- Revenue -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700">Doanh thu</h2>
                <p class="text-4xl font-bold text-green-500 mt-2">
                    {{ doanhThu ? formatCurrency(doanhThu) : 0 }}
                </p>
                <!-- <span class="text-sm text-gray-500">{{ timeDescription }}</span> -->
            </div>

            <!-- Dishes Sold -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700">Món ăn bán</h2>
                <p class="text-4xl font-bold text-blue-500 mt-2">
                    {{ tongMonAn ? tongMonAn : 0 }}
                </p>
                <!-- <span class="text-sm text-gray-500">{{ timeDescription }}</span> -->
            </div>
        </div>

        <!-- Best-Selling and Least-Selling Dishes -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
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
        </div>

        <!-- Order Success and Failure Rates -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
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
    </div>
</template>
