<script setup>
import { useForm } from "@inertiajs/vue3";
// import { route } from "../../../../../vendor/tightenco/ziggy/src/js";
const form = useForm({
    email: "",
    password: "",
});

const login = () => {
    form.post(route("admin.login"), {
        onError: () => form.reset("password"),
    });
};
</script>

<template>
    <section class="bg-gray-50">
        <div
            class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0"
        >
            <div
                class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0"
            >
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl"
                    >
                        Sign in to your account
                    </h1>
                    <form
                        class="space-y-4 md:space-y-6"
                        @submit.prevent="login"
                    >
                        <div>
                            <label
                                for="email"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Your email</label
                            >
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="bg-gray-50 border text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                :class="
                                    form.errors.email
                                        ? 'bg-red-50 border-red-500'
                                        : 'bg-gray-50 border-gray-300'
                                "
                                placeholder="name@company.com"
                                v-model="form.email"
                            />
                            <span
                                class="text-sm text-red-400"
                                v-if="form.errors.email"
                                >{{ form.errors.email }}</span
                            >
                        </div>
                        <div>
                            <label
                                for="password"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Password</label
                            >
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                v-model="form.password"
                                :class="
                                    form.errors.password
                                        ? 'bg-red-50 border-red-500'
                                        : ' border-gray-300'
                                "
                            />
                            <span
                                class="text-sm text-red-400"
                                v-if="form.errors.password"
                                >{{ form.errors.password }}</span
                            >
                        </div>

                        <button
                            :disabled="form.processing"
                            type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        >
                            Sign in
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>
