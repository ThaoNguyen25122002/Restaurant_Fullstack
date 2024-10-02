<script setup>
import { useForm } from "@inertiajs/vue3";
import CustomerLayout from "../../../Layouts/Customer/CustomerLayout.vue";
defineOptions({
    layout: CustomerLayout,
});

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    address: null,
    phone: null,
    remember: false,
});
const register = () => {
    console.log(form);
    form.post(route("handle.register"), {
        onError: () => {
            form.reset("password", "password_confirmation");
        },
    });
};
</script>

<template>
    <div class="h-screen flex items-center justify-center bg-gray-100">
        <!-- Background Image -->
        <div
            class="w-full h-full absolute inset-0 bg-cover bg-center"
            :style="'background-image: url(/storage/background/bg-login.jpg);'"
        ></div>

        <!-- Overlay to darken background -->
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>

        <!-- Registration Form Container -->
        <div
            class="mt-[72px] relative z-10 bg-white bg-opacity-40 backdrop-blur-sm p-8 rounded-lg shadow-lg max-w-4xl w-full mx-4"
        >
            <h2 class="text-3xl font-semibold text-center text-red-700 mb-6">
                Đăng Ký
            </h2>

            <!-- Registration Form -->
            <form class="space-y-3" @submit.prevent="register">
                <!-- Row 1: Name and Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700"
                            >Họ và Tên
                            <span class="text-red-600">*</span></label
                        >
                        <input
                            id="name"
                            type="text"
                            v-model="form.name"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                        />
                        <small class="text-rose-100">{{
                            form.errors.name
                        }}</small>
                    </div>

                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700"
                            >Email <span class="text-red-600">*</span></label
                        >
                        <input
                            id="email"
                            type="email"
                            v-model="form.email"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                        />
                        <small class="text-rose-100">{{
                            form.errors.email
                        }}</small>
                    </div>
                </div>

                <!-- Row 2: Password and Password Confirmation -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700"
                            >Mật Khẩu <span class="text-red-600">*</span></label
                        >
                        <input
                            id="password"
                            type="password"
                            v-model="form.password"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                        />
                        <small class="text-rose-100">{{
                            form.errors.password
                        }}</small>
                    </div>

                    <div>
                        <label
                            for="password_confirm"
                            class="block text-sm font-medium text-gray-700"
                            >Xác Nhận Mật Khẩu
                            <span class="text-red-600">*</span></label
                        >
                        <input
                            id="password_confirm"
                            type="password"
                            v-model="form.password_confirmation"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                        />
                    </div>
                </div>

                <!-- Row 3: Address and Phone -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label
                            for="address"
                            class="block text-sm font-medium text-gray-700"
                            >Địa Chỉ</label
                        >
                        <input
                            id="address"
                            type="text"
                            v-model="form.address"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                        />
                        <small class="text-rose-100">{{
                            form.errors.address
                        }}</small>
                    </div>

                    <div>
                        <label
                            for="phone"
                            class="block text-sm font-medium text-gray-700"
                            >Số Điện Thoại</label
                        >
                        <input
                            id="phone"
                            type="text"
                            v-model="form.phone"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                        />
                        <small class="text-rose-100">{{
                            form.errors.phone
                        }}</small>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                    >
                        Đăng Ký
                    </button>
                </div>
            </form>

            <!-- Already have an account -->
            <p class="mt-6 text-center text-gray-600">
                Đã có tài khoản?
                <Link
                    :href="route('login')"
                    class="font-medium text-red-600 hover:text-red-500"
                    >Đăng nhập ngay</Link
                >
            </p>
        </div>
    </div>
</template>
