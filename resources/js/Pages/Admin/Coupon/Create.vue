<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
defineOptions({
    layout: AdminLayout,
});

const form = useForm({
    code: null,
    discount_percentage: null,
    quantity: null,
    start_date: null,
    end_date: null,
});

const handleCreate = () => {
    console.log(form);
    form.post(route("admin.coupons.store"), {
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
    });
};
</script>

<template>
    <div class="min-h-screen bg-gray-100 p-8">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-700">
                Tạo Mã Giảm Giá Mới
            </h2>
        </div>

        <!-- Form for Creating Discount Code -->
        <div class="bg-white shadow-lg rounded-lg p-6 max-w-lg mx-auto">
            <form @submit.prevent="handleCreate">
                <!-- Mã Giảm Giá -->
                <div class="mb-4">
                    <label
                        for="code"
                        class="block text-sm font-medium text-gray-700"
                        >Mã Giảm Giá</label
                    >
                    <input
                        type="text"
                        id="code"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Nhập mã giảm giá"
                        v-model="form.code"
                    />
                    <small class="text-red-500">{{ form.errors.code }}</small>
                </div>

                <!-- Giảm Giá (%) -->
                <div class="mb-4">
                    <label
                        for="discount_percentage"
                        class="block text-sm font-medium text-gray-700"
                        >Phần Trăm Giảm Giá (%)</label
                    >
                    <input
                        type="number"
                        id="discount_percentage"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        min="1"
                        max="100"
                        placeholder="Nhập phần trăm giảm giá"
                        v-model="form.discount_percentage"
                    />
                    <small class="text-red-500">{{
                        form.errors.discount_percentage
                    }}</small>
                </div>

                <!-- Số Lượng Mã Có Thể Sử Dụng -->
                <div class="mb-4">
                    <label
                        for="quantity"
                        class="block text-sm font-medium text-gray-700"
                        >Số Lượng Mã Có Thể Sử Dụng</label
                    >
                    <input
                        type="number"
                        id="quantity"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        min="1"
                        placeholder="Nhập số lượng mã"
                        v-model="form.quantity"
                    />
                    <small class="text-red-500">{{
                        form.errors.quantity
                    }}</small>
                </div>

                <!-- Ngày Bắt Đầu -->
                <div class="mb-4">
                    <label
                        for="start_date"
                        class="block text-sm font-medium text-gray-700"
                        >Ngày Bắt Đầu</label
                    >
                    <input
                        type="date"
                        id="start_date"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        v-model="form.start_date"
                    />
                    <small class="text-red-500">{{
                        form.errors.start_date
                    }}</small>
                </div>

                <!-- Ngày Kết Thúc -->
                <div class="mb-4">
                    <label
                        for="end_date"
                        class="block text-sm font-medium text-gray-700"
                        >Ngày Kết Thúc</label
                    >
                    <input
                        type="date"
                        id="end_date"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        v-model="form.end_date"
                    />
                    <small class="text-red-500">{{
                        form.errors.end_date
                    }}</small>
                </div>

                <!-- Nút Lưu -->
                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="bg-gradient-to-r from-green-400 to-teal-500 text-white px-6 py-2 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300"
                    >
                        Lưu Mã Giảm Giá
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
