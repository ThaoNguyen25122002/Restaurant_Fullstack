<script setup>
import { useForm } from "@inertiajs/vue3";
import CustomerLayout from "../../../Layouts/Customer/CustomerLayout.vue";
defineOptions({
    layout: CustomerLayout,
});

const form = useForm({
    email: null,
    password: null,
    remember: false,
});
const login = () => {
    console.log(form);
    form.post(route("handle.login"), {
        onError: () => {
            form.reset("password");
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

        <!-- Login Form Container -->
        <div
            class="mt-[40px] relative z-10 bg-white bg-opacity-40 backdrop-blur-sm p-8 rounded-lg shadow-lg max-w-md w-full mx-4"
        >
            <h2 class="text-3xl font-semibold text-center text-red-700 mb-6">
                Đăng Nhập
            </h2>

            <!-- Login Form -->
            <form class="space-y-6" @submit.prevent="login">
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700"
                        >Email</label
                    >
                    <input
                        id="email"
                        type="text"
                        v-model="form.email"
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                    />
                    <small class="text-rose-100">{{ form.errors.email }}</small>
                </div>

                <div>
                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700"
                        >Mật Khẩu</label
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

                <!-- Remember me and Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            v-model="form.remember"
                            class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded"
                        />
                        <span class="ml-2 text-sm text-slate-200"
                            >Nhớ tài khoản</span
                        >
                    </label>
                    <Link
                        :href="route('sendResetLinkEmail')"
                        class="text-sm font-medium text-slate-200 hover:text-red-500"
                        >Quên mật khẩu?</Link
                    >
                </div>

                <!-- Submit Button -->
                <div>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                    >
                        Đăng Nhập
                    </button>
                </div>
            </form>

            <!-- Already have an account -->
            <p class="mt-6 text-center text-slate-200">
                Chưa có tài khoản?
                <Link
                    :href="route('register')"
                    class="font-medium text-red-500 hover:text-red-300"
                    >Đăng ký ngay</Link
                >
            </p>
        </div>
    </div>
</template>
