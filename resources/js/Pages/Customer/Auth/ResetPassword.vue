<script setup>
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
const queryParams = new URLSearchParams(window.location.search);
const email = queryParams.get("email");
const token = queryParams.get("token");
const form = useForm({
    email: email,
    token: token,
    password: null,
    password_confirmation: null,
});
const resetPassword = () => {
    form.post(route("handle.resetPassword"), {
        onSuccess: (page) => {
            Swal.fire({
                title: "Thành công!",
                text: page.props.flash.success,
                icon: "success",
            });
        },
        onError: (errors) => {
            // console.log(errors[0]);
            Swal.fire({
                // title: "Tha!",
                text: errors[0],
                icon: "error",
            });
        },
    });
};
console.log("Email:", email);
console.log("Token:", token);
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-semibold text-center text-red-700 mb-6">
                Đặt Lại Mật Khẩu
            </h2>

            <form @submit.prevent="resetPassword">
                <!-- Email Field -->
                <div class="mb-4">
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700"
                        >Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        v-model="form.email"
                        disabled
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    />
                    <small class="text-red-500">{{ form.errors.email }}</small>
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700"
                        >Mật Khẩu Mới</label
                    >
                    <input
                        type="password"
                        id="password"
                        name="password"
                        v-model="form.password"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    />
                    <small class="text-red-500">{{
                        form.errors.password
                    }}</small>
                </div>

                <!-- Confirm Password Field -->
                <div class="mb-4">
                    <label
                        for="password_confirmation"
                        class="block text-sm font-medium text-gray-700"
                        >Xác Nhận Mật Khẩu</label
                    >
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        v-model="form.password_confirmation"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    />
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button
                        type="submit"
                        class="w-full text-white py-2 px-4 rounded-md bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                    >
                        Reset Password
                    </button>
                </div>
            </form>

            <!-- <div class="mt-4 text-center">
                <a
                    href="/login"
                    class="text-sm text-indigo-600 hover:text-indigo-500"
                    >Back to Login</a
                >
            </div> -->
        </div>
    </div>
</template>
