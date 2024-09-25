<script setup>
import { router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Swal from "sweetalert2";
import FormSearch from "@/components/Admin/FormSearch/Index.vue";
const props = defineProps({
    users: Object,
    roles: Array,
    searchTerm: String,
    // openEditModal: Function,
    // form: Object,
});
const form = useForm({
    email: "",
    name: "",
    password: "",
    password_confirmation: "",
    phone: "",
    address: "",
    role_id: 3,
});
const searchQuery = ref(props.searchTerm || "");
const isAddProducts = ref(false);
const dialogVisible = ref(false);
const editMode = ref(false);
const openAddModal = () => {
    isAddProducts.value = true;
    dialogVisible.value = true;
    editMode.value = false;
};
const openEditModal = () => {
    editMode.value = true;
    isAddProducts.value = false;
    dialogVisible.value = true;
};
const handleCreateUser = () => {
    form.post(route("admin.users.store"), {
        onSuccess: (page) => {
            Swal.fire({
                toast: true,
                icon: "success",
                position: "top-end",
                showConfirmButton: false,
                title: page.props.flash.success,
                timer: 1500,
            });
            form.reset();
            dialogVisible.value = false;
        },
    });
    // console.log(form);
};
const testClick = () => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success",
            });
        }
    });
};

const handleEditUser = (user) => {
    form.id = user.id;
    form.name = user.name;
    form.email = user.email;
    form.phone = user.phone;
    form.address = user.address;
    form.role_id = user.role_id;
    openEditModal();
    // console.log(form);
};
const updateUser = () => {
    console.log(form);

    form.put(route("admin.users.update", { id: form.id }), {
        onSuccess: (page) => {
            form.reset();
            dialogVisible.value = false;
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
const handleClose = () => {
    form.clearErrors();
    form.reset();
    dialogVisible.value = false;
};

const deleteUser = (user) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`users/${user.id}/delete`, {
                onSuccess: (page) => {
                    Swal.fire({
                        title: "Deleted!",
                        text: page.props.flash.success,
                        icon: "success",
                    });
                },
            });
        }
    });
};
// Search
const handleSearch = (value) => {
    // console.log(value);
    if (searchQuery.value === props.searchTerm) {
        return;
    }
    // console.log(123);
    router.get(route("admin.users"), { search: searchQuery.value });
};
</script>

<template>
    <!-- Dialog Form Create or Edit User -->

    <el-dialog
        v-model="dialogVisible"
        :title="editMode ? 'Edit User' : 'Create User'"
        width="500"
        :before-close="handleClose"
    >
        <!-- Form -->

        <form
            class="max-w-md mx-auto"
            @submit.prevent="editMode ? updateUser() : handleCreateUser()"
        >
            <div class="relative z-0 w-full mb-5 group">
                <input
                    type="text"
                    name="floating_email"
                    id="floating_email"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" "
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
            <div class="relative z-0 w-full mb-5 group" v-if="!editMode">
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
                    >Mật khẩu <span class="text-red-500">*</span></label
                >
                <span class="text-red-400" v-if="form.errors.password">{{
                    form.errors.password
                }}</span>
            </div>
            <div class="relative z-0 w-full mb-5 group" v-if="!editMode">
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
                    >Nhập lại mật khẩu
                    <span class="text-red-500">*</span></label
                >
            </div>
            <div class="mb-4">
                <label
                    for="roles"
                    class="block mb-2 text-sm font-medium text-gray-500"
                    >Roles <span class="text-red-500">*</span></label
                >
                <select
                    id="roles"
                    v-model="form.role_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                >
                    <option
                        v-for="role in roles"
                        :key="role.id"
                        :value="role.id"
                    >
                        {{ role.name }}
                    </option>
                </select>
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
    <!-- <h1 class="text-red-500 z-20">{{ searchQuery }}</h1> -->
    <section class="bg-gray-50">
        <div class="mx-auto max-w-screen-xl">
            <!-- Start coding here -->
            <div
                class="bg-white relative shadow-md sm:rounded-lg overflow-hidden"
            >
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4"
                >
                    <!-- Search -->
                    <FormSearch
                        v-model="searchQuery"
                        @onSearch="handleSearch"
                    />
                    <!-- End Search -->
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0"
                    >
                        <button
                            @click="openAddModal"
                            type="button"
                            class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none"
                        >
                            <svg
                                class="h-3.5 w-3.5 mr-2"
                                fill="currentColor"
                                viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true"
                            >
                                <path
                                    clip-rule="evenodd"
                                    fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                />
                            </svg>
                            Add product
                        </button>
                        <div
                            class="flex items-center space-x-3 w-full md:w-auto"
                        >
                            <button
                                id="actionsDropdownButton"
                                data-dropdown-toggle="actionsDropdown"
                                class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200"
                                type="button"
                            >
                                <svg
                                    class="-ml-1 mr-1.5 w-5 h-5"
                                    fill="currentColor"
                                    viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true"
                                >
                                    <path
                                        clip-rule="evenodd"
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    />
                                </svg>
                                Actions
                            </button>
                            <div
                                id="actionsDropdown"
                                class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow"
                            >
                                <ul
                                    class="py-1 text-sm text-gray-700"
                                    aria-labelledby="actionsDropdownButton"
                                >
                                    <li>
                                        <a
                                            href="#"
                                            class="block py-2 px-4 hover:bg-gray-100"
                                            >Mass Edit</a
                                        >
                                    </li>
                                </ul>
                                <div class="py-1">
                                    <a
                                        href="#"
                                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100"
                                        >Delete all</a
                                    >
                                </div>
                            </div>
                            <button
                                id="filterDropdownButton"
                                data-dropdown-toggle="filterDropdown"
                                class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200"
                                type="button"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true"
                                    class="h-4 w-4 mr-2 text-gray-400"
                                    viewbox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Filter
                                <svg
                                    class="-mr-1 ml-1.5 w-5 h-5"
                                    fill="currentColor"
                                    viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true"
                                >
                                    <path
                                        clip-rule="evenodd"
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    />
                                </svg>
                            </button>
                            <div
                                id="filterDropdown"
                                class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow"
                            >
                                <h6
                                    class="mb-3 text-sm font-medium text-gray-900"
                                >
                                    Choose brand
                                </h6>
                                <ul
                                    class="space-y-2 text-sm"
                                    aria-labelledby="filterDropdownButton"
                                >
                                    <li class="flex items-center">
                                        <input
                                            id="apple"
                                            type="checkbox"
                                            value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2"
                                        />
                                        <label
                                            for="apple"
                                            class="ml-2 text-sm font-medium text-gray-900"
                                            >Apple (56)</label
                                        >
                                    </li>
                                    <li class="flex items-center">
                                        <input
                                            id="fitbit"
                                            type="checkbox"
                                            value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2"
                                        />
                                        <label
                                            for="fitbit"
                                            class="ml-2 text-sm font-medium text-gray-900"
                                            >Microsoft (16)</label
                                        >
                                    </li>
                                    <li class="flex items-center">
                                        <input
                                            id="razor"
                                            type="checkbox"
                                            value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2"
                                        />
                                        <label
                                            for="razor"
                                            class="ml-2 text-sm font-medium text-gray-900"
                                            >Razor (49)</label
                                        >
                                    </li>
                                    <li class="flex items-center">
                                        <input
                                            id="nikon"
                                            type="checkbox"
                                            value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2"
                                        />
                                        <label
                                            for="nikon"
                                            class="ml-2 text-sm font-medium text-gray-900"
                                            >Nikon (12)</label
                                        >
                                    </li>
                                    <li class="flex items-center">
                                        <input
                                            id="benq"
                                            type="checkbox"
                                            value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2"
                                        />
                                        <label
                                            for="benq"
                                            class="ml-2 text-sm font-medium text-gray-900"
                                            >BenQ (74)</label
                                        >
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50"
                        >
                            <tr>
                                <th scope="col" class="px-4 py-3">Tên</th>
                                <th scope="col" class="px-4 py-3">Email</th>
                                <th scope="col" class="px-4 py-3">Quyền</th>
                                <th scope="col" class="px-4 py-3">
                                    Số điện thoại
                                </th>
                                <th scope="col" class="px-4 py-3">Địa chỉ</th>
                                <th scope="col" class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="border-b"
                                v-for="user in users.data"
                                :key="user.id"
                            >
                                <th
                                    scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    {{ user.name }}
                                </th>
                                <td class="px-4 py-3">{{ user.email }}</td>
                                <td class="px-4 py-3">{{ user.role.name }}</td>
                                <td class="px-4 py-3">
                                    {{
                                        user.phone
                                            ? user.phone
                                            : "Chưa cập nhật"
                                    }}
                                </td>
                                <td class="px-4 py-3">
                                    {{
                                        user.address
                                            ? user.address
                                            : "Chưa cập nhật"
                                    }}
                                </td>
                                <td class="px-4 py-3 flex items-center gap-4">
                                    <div>
                                        <button @click="handleEditUser(user)">
                                            <svg
                                                class="size-5 text-gray-800"
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
                                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"
                                                />
                                            </svg>
                                        </button>
                                        <button @click="deleteUser(user)">
                                            <svg
                                                class="size-5 text-gray-800"
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
                                                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</template>
