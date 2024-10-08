<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
defineOptions({ layout: AdminLayout });

const formatCurrency = (value) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
};
</script>

<template>
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-6">Thống kê đơn hàng</h2>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700"
                >Chọn khoảng thời gian</label
            >
            <select
                class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <option value="today">Theo ngày</option>
                <option value="week">Theo tuần</option>
                <option value="month">Theo tháng</option>
                <option value="year">Theo năm</option>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Tổng số đơn hàng -->
            <div class="bg-gray-100 p-4 rounded-lg shadow">
                <h3 class="font-semibold text-lg">Tổng số đơn hàng</h3>
                <p class="text-2xl font-bold">150</p>
            </div>

            <!-- Đơn hàng thành công -->
            <div class="bg-green-100 p-4 rounded-lg shadow">
                <h3 class="font-semibold text-lg">Đơn hàng thành công</h3>
                <p class="text-2xl font-bold">120</p>
            </div>

            <!-- Đơn hàng thất bại -->
            <div class="bg-red-100 p-4 rounded-lg shadow">
                <h3 class="font-semibold text-lg">Đơn hàng thất bại</h3>
                <p class="text-2xl font-bold">30</p>
            </div>

            <!-- Tỷ lệ thành công -->
            <div class="bg-blue-100 p-4 rounded-lg shadow">
                <h3 class="font-semibold text-lg">Tỷ lệ thành công</h3>
                <p class="text-2xl font-bold">80%</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <!-- Tổng doanh thu -->
            <div class="bg-purple-100 p-4 rounded-lg shadow">
                <h3 class="font-semibold text-lg">Tổng doanh thu</h3>
                <p class="text-2xl font-bold">{{ formatCurrency(15000000) }}</p>
            </div>

            <!-- Số lượng khách hàng mới -->
            <div class="bg-teal-100 p-4 rounded-lg shadow">
                <h3 class="font-semibold text-lg">Khách hàng mới</h3>
                <p class="text-2xl font-bold">20</p>
            </div>

            <!-- Số lượng đơn hàng đang xử lý -->
            <div class="bg-yellow-100 p-4 rounded-lg shadow">
                <h3 class="font-semibold text-lg">Đơn hàng đang xử lý</h3>
                <p class="text-2xl font-bold">15</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <!-- Số lượng đơn hàng theo giờ -->
            <div class="bg-gray-100 p-4 rounded-lg shadow">
                <h3 class="font-semibold text-lg">
                    Số lượng đơn hàng theo giờ
                </h3>
                <p class="text-2xl font-bold">50</p>
                <p class="text-sm text-gray-600">Giờ cao điểm: 18:00 - 20:00</p>
                <p class="text-sm text-gray-600">
                    Giờ thấp điểm: 10:00 - 11:00
                </p>
            </div>

            <!-- Đơn hàng gần đây nhất -->
            <div class="bg-yellow-100 p-4 rounded-lg shadow">
                <h3 class="font-semibold text-lg">Đơn hàng gần đây nhất</h3>
                <p class="text-lg">#ORD123456</p>
                <p class="text-sm text-gray-600">Ngày: 2024-10-07</p>
            </div>

            <!-- Danh sách đơn hàng chưa giao và đã hoàn thành -->
            <div class="bg-gray-100 p-4 rounded-lg shadow">
                <h3 class="font-semibold text-lg">Đơn hàng chưa giao</h3>
                <ul class="list-disc pl-5">
                    <li>#ORD123457 - Khách hàng A</li>
                    <li>#ORD123458 - Khách hàng B</li>
                    <li>#ORD123459 - Khách hàng C</li>
                </ul>
                <h3 class="font-semibold text-lg mt-4">
                    Đơn hàng đã hoàn thành
                </h3>
                <ul class="list-disc pl-5">
                    <li>#ORD123450 - Khách hàng D</li>
                    <li>#ORD123451 - Khách hàng E</li>
                    <li>#ORD123452 - Khách hàng F</li>
                </ul>
            </div>
        </div>
    </div>
</template>
