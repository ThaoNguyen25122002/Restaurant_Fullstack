<script setup>
import Swal from "sweetalert2";
import { useForm, usePage } from "@inertiajs/vue3";
import CustomerLayout from "../../../Layouts/Customer/CustomerLayout.vue";
defineOptions({
    layout: CustomerLayout,
});

const page = usePage();
const form = useForm({
    name: page.props.auth.user.name,
    email: page.props.auth.user.email,
    address: page.props.auth.user.address,
    phone: page.props.auth.user.phone,
    password: null,
    password_confirmation: null,
});
const update = () => {
    form.put(route("profile.update", { id: page.props.auth.user.id }), {
        onSuccess: (page) => {
            Swal.fire({
                title: "Thành công!",
                text: page.props.flash.success,
                icon: "success",
            });
            form.reset("password", "password_confirmation");
        },
    });
};
form.put;
</script>

<template>
    <div
        class="bg-gray-100 h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8"
    >
        <div
            class="mt-[72px] w-full max-w-lg sm:max-w-xl lg:max-w-3xl xl:max-w-5xl mx-auto bg-white p-6 sm:p-8 rounded-lg shadow-lg"
        >
            <h2
                class="text-2xl sm:text-3xl font-bold text-red-600 text-center mb-4"
            >
                Tài Khoản
            </h2>
            <form
                @submit.prevent="update"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6"
            >
                <!-- Left Column: Personal Info -->
                <div class="space-y-3">
                    <!-- Name -->
                    <div class="flex flex-col">
                        <label for="name" class="text-gray-700 font-semibold"
                            >Tên <span class="text-red-500">*</span></label
                        >
                        <input
                            type="text"
                            id="name"
                            v-model="form.name"
                            name="name"
                            class="mt-2 p-2 sm:p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600"
                            placeholder="Enter your name"
                        />
                        <small class="text-red-500">{{
                            form.errors.name
                        }}</small>
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col">
                        <label for="email" class="text-gray-700 font-semibold"
                            >Email <span class="text-red-500">*</span></label
                        >
                        <input
                            type="text"
                            disabled
                            id="email"
                            v-model="form.email"
                            name="email"
                            class="mt-2 p-2 sm:p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600"
                            placeholder="Enter your email"
                        />
                        <small class="text-red-500">{{
                            form.errors.email
                        }}</small>
                    </div>

                    <!-- Phone Number -->
                    <div class="flex flex-col">
                        <label for="phone" class="text-gray-700 font-semibold"
                            >Số Điện Thoại</label
                        >
                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            v-model="form.phone"
                            class="mt-2 p-2 sm:p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600"
                            placeholder="Enter your phone number"
                        />
                        <small class="text-red-500">{{
                            form.errors.phone
                        }}</small>
                    </div>
                </div>

                <!-- Right Column: Password and Address -->
                <div class="space-y-3">
                    <!-- Password -->
                    <div class="flex flex-col">
                        <label
                            for="password"
                            class="text-gray-700 font-semibold"
                            >Mật Khẩu Mới</label
                        >
                        <input
                            type="password"
                            id="password"
                            name="password"
                            v-model="form.password"
                            class="mt-2 p-2 sm:p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600"
                            placeholder="Enter new password"
                        />
                        <small class="text-red-500">{{
                            form.errors.password
                        }}</small>
                    </div>

                    <!-- Confirm Password -->
                    <div class="flex flex-col">
                        <label
                            for="confirm-password"
                            class="text-gray-700 font-semibold"
                            >Nhập Lại Mật Khẩu Mới</label
                        >
                        <input
                            type="password"
                            id="confirm-password"
                            v-model="form.password_confirmation"
                            name="confirm-password"
                            class="mt-2 p-2 sm:p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600"
                            placeholder="Confirm new password"
                        />
                    </div>

                    <!-- Address -->
                    <div class="flex flex-col">
                        <label for="address" class="text-gray-700 font-semibold"
                            >Địa Chỉ</label
                        >
                        <textarea
                            id="address"
                            name="address"
                            v-model="form.address"
                            rows="2"
                            class="mt-2 p-2 sm:p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600"
                            placeholder="Enter your address"
                        ></textarea>
                        <small class="text-red-500">{{
                            form.errors.address
                        }}</small>
                    </div>
                </div>

                <!-- Submit Button (Spans Across Two Columns) -->
                <div class="col-span-1 md:col-span-2 text-center mt-4">
                    <button
                        type="submit"
                        class="bg-red-600 text-white px-6 py-2 sm:py-3 rounded-md font-semibold hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-400"
                    >
                        Cập Nhật Thông Tin
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
