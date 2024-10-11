<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import Swal from "sweetalert2";
const dialogVisible = ref(false);

const handleClose = () => {
    form.clearErrors();
    // form.reset();
    dialogVisible.value = false;
};
const page = usePage();
// console.log(page.props.auth.user);
const form = useForm({
    email: page.props.auth.user.email,
    name: page.props.auth.user.name,
    address: page.props.auth.user.address,
    role: page.props.auth.user.role.name,
    phone: page.props.auth.user.phone,
    password: null,
    password_confirmation: null,
});
const updateProfile = () => {
    console.log(form);
    form.put(route("admin.profile.update", { id: page.props.auth.user.id }), {
        onSuccess: (page) => {
            Swal.fire({
                toast: true,
                icon: "success",
                position: "top-end",
                showConfirmButton: false,
                title: page.props.flash.success,
                timer: 1500,
            });
            handleClose();
        },
    });
};
</script>
<template>
    <!-- Dialog Form Create or Edit User -->

    <el-dialog
        v-model="dialogVisible"
        title="Cập Nhật Profile"
        width="500"
        :before-close="handleClose"
    >
        <!-- Form -->

        <form class="max-w-md mx-auto" @submit.prevent="updateProfile">
            <div class="relative z-0 w-full mb-5 group">
                <input
                    type="text"
                    name="floating_email"
                    id="floating_email"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" "
                    disabled
                    v-model="form.email"
                />
                <label
                    for="floating_email"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-8 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-8"
                    >Email <span class="text-red-500">*</span></label
                >
                <span class="text-red-400" v-if="form.errors.email">{{
                    form.errors.email
                }}</span>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input
                    type="text"
                    name="floating_name"
                    id="floating_name"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" "
                    v-model="form.name"
                />
                <label
                    for="floating_name"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-8 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-8"
                    >Họ Tên <span class="text-red-500">*</span></label
                >
                <span class="text-red-400" v-if="form.errors.name">{{
                    form.errors.email
                }}</span>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input
                    type="password"
                    name="floating_password"
                    id="floating_password"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" "
                    v-model="form.password"
                />
                <label
                    for="floating_password"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-8 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-8"
                    >Mật khẩu mới</label
                >
                <span class="text-red-400" v-if="form.errors.password">{{
                    form.errors.password
                }}</span>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input
                    type="password"
                    name="repeat_password"
                    id="floating_repeat_password"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" "
                    v-model="form.password_confirmation"
                />
                <label
                    for="floating_repeat_password"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-8 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-8"
                    >Nhập lại mật khẩu mới
                </label>
            </div>

            <!-- <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input
                        type="text"
                        name="floating_first_name"
                        id="floating_first_name"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="floating_first_name"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-8 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-8"
                        >First name <span class="text-red-500">*</span></label
                    >
                    <span class="text-red-400" v-if="form.errors.name">{{
                        form.errors.name
                    }}</span>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input
                        type="text"
                        name="floating_last_name"
                        id="floating_last_name"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="floating_last_name"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-8 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-8"
                        >Last name</label
                    >
                </div>
            </div> -->
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input
                        type="tel"
                        name="floating_phone"
                        id="floating_phone"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        v-model="form.phone"
                    />
                    <label
                        for="floating_phone"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-8 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-8"
                        >Số điện thoại
                    </label>
                    <span class="text-red-400" v-if="form.errors.phone">{{
                        form.errors.phone
                    }}</span>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input
                        type="text"
                        name="floating_company"
                        id="floating_company"
                        v-model="form.address"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="floating_company"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-8 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-8"
                        >Địa chỉ (số nhà tại TP Đà Nẵng)</label
                    >
                    <span class="text-red-400" v-if="form.errors.address">{{
                        form.errors.address
                    }}</span>
                </div>
            </div>
            <button
                type="submit"
                :disabled="form.processing"
                class="disabled:bg-gray-400 disabled:cursor-not-allowed text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 ml-auto block"
            >
                Submit
            </button>
        </form>

        <!-- End Form -->

        <!-- <template #footer>
            <div class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="dialogVisible = false">
                    Confirm
                </el-button>
            </div>
        </template> -->
    </el-dialog>
    <!-- End Dialog Form Create or Edit User -->
    <div
        class="sm:ml-64 fixed top-0 right-0 left-0 shadow-xl bg-slate-50 px-4 z-30"
    >
        <div class="flex justify-between">
            <div class="flex items-center">
                <img :src="'/storage/Logo/logokfc.png'" alt="" class="h-14" />
                <!-- <div class="hidden sm:block">
                    <label
                        for="default-search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
                        >Search</label
                    >
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
                        >
                            <svg
                                class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                />
                            </svg>
                        </div>
                        <input
                            type="search"
                            id="default-search"
                            class="block w-[300px] px-1 py-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search Mockups, Logos..."
                        />
                    </div>
                </div> -->
            </div>
            <div class="group relative cursor-pointer">
                <div class="flex justify-center items-center gap-2">
                    <div>
                        <h4 class="text-lg">
                            {{ $page.props.auth.user.name }}
                        </h4>
                        <p class="text-sm text-gray-500">Admin</p>
                    </div>
                    <svg
                        class="w-6 h-6 text-gray-800"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M7.119 8h9.762a1 1 0 0 1 .772 1.636l-4.881 5.927a1 1 0 0 1-1.544 0l-4.88-5.927A1 1 0 0 1 7.118 8Z"
                        />
                    </svg>
                </div>
                <ul
                    class="absolute hidden group-hover:block bg-white text-black p-2 shadow-md rounded-md left-[-20%] right-0 top-[100%]"
                >
                    <li
                        @click="dialogVisible = true"
                        class="inline-block py-1 px-2 w-full hover:bg-slate-100"
                    >
                        Profile
                    </li>
                    <Link
                        :href="route('admin.logout')"
                        method="post"
                        as="button"
                        class="inline-block py-1 px-2 w-full hover:bg-slate-100 text-start"
                    >
                        Logout
                    </Link>
                </ul>
            </div>
        </div>
    </div>
</template>
