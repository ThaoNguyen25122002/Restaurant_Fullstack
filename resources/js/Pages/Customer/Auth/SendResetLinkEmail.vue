<script setup>
import { ref } from "vue";
import Swal from "sweetalert2";
import { router, useForm } from "@inertiajs/vue3";
import CustomerLayout from "../../../Layouts/Customer/CustomerLayout.vue";
defineOptions({
    layout: CustomerLayout,
});

const form = useForm({
    email: null,
});
const sendLinkReset = () => {
    console.log(email.value);
    form.post(route("handle.sendResetLinkEmail"), {
        onSuccess: (page) => {
            Swal.fire({
                title: "Đã gửi!",
                text: page.props.flash.success,
                icon: "success",
            });
            form.reset();
        },
    });
};
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-semibold text-center text-red-700 mb-6">
                Reset Password
            </h2>

            <form @submit.prevent="sendLinkReset">
                <!-- Email Field -->
                <div class="mb-4">
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700"
                        >Email
                    </label>
                    <input
                        type="text"
                        id="email"
                        name="email"
                        v-model="form.email"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    />
                    <span class="text-red-500">{{ form.errors.email }}</span>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button
                        type="submit"
                        class="w-full text-white py-2 px-4 rounded-md bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                    >
                        Send Link
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <Link
                    :href="route('login')"
                    class="text-sm text-red-600 hover:text-red-500"
                    >Back to Login</Link
                >
            </div>
        </div>
    </div>
</template>
