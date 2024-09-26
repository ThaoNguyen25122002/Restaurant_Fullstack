<script setup>
import { router, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import Swal from "sweetalert2";
import FormSearch from "@/components/Admin/FormSearch/Index.vue";

const page = usePage();
// const categories = ref(page.props.categories);
const props = defineProps({
    categories: Array,
    searchTerm: String,
});
// console.log(categories.value);
const fileInput = ref(null);
const form = useForm({
    id: null,
    category_name: "",
    category_image: null,
    newImage: null,
    sort: 1,
    is_show: 1,
});
const searchQuery = ref(props.searchTerm || "");
const isAddProducts = ref(false);
const dialogVisible = ref(false);
const editMode = ref(false);
const imagePreview = ref(null);
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
const showEditCategory = (category) => {
    openEditModal();
    // form = category;
    // console.log(form);
    form.category_name = category.category_name;
    form.category_image = category.category_image;
    // imagePreview.value = category.category_name;
    form.sort = category.sort;
    form.is_show = category.is_show;
    // form._method = "PUT";
    form.id = category.id;
};
const handleClose = () => {
    if (imagePreview.value) {
        fileInput.value.value = null;
        URL.revokeObjectURL(imagePreview.value);
        imagePreview.value = null;
    }
    form.clearErrors();
    form.reset();
    dialogVisible.value = false;
};

const updateCategory = () => {
    console.log(form);
    form.post(route("admin.categories.update", { id: form.id }), {
        onSuccess: (page) => {
            form.reset();
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
const createCategory = () => {
    // console.log(form);
    form.post(route("admin.categories.create"), {
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

const onChange = (event) => {
    const file = event.target.files[0];

    if (imagePreview.value) {
        URL.revokeObjectURL(imagePreview.value);
    }
    console.log(form);
    if (file && file.type.startsWith("image/")) {
        form.clearErrors("category_image");
        imagePreview.value = URL.createObjectURL(file);

        if (editMode.value) {
            form.newImage = file;
        } else {
            form.category_image = file;
        }
    }
    console.log(form);
};
// Search
const handleSearch = (value) => {
    // console.log(value);
    if (searchQuery.value === props.searchTerm) {
        return;
    }
    // console.log(123);
    router.get(route("admin.categories"), { search: searchQuery.value });
};
</script>

<template>
    <!-- Dialog Form Create or Edit User -->

    <el-dialog
        v-model="dialogVisible"
        :title="editMode ? 'Cập Nhật Danh Mục' : 'Tạo Danh Mục'"
        width="500"
        :before-close="handleClose"
    >
        <!-- Form -->

        <form @submit.prevent="editMode ? updateCategory() : createCategory()">
            <div class="mb-2">
                <label
                    for="category"
                    class="block mb-2 text-sm font-medium text-gray-900"
                    >Danh mục</label
                >
                <input
                    type="text"
                    id="category"
                    v-model="form.category_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Tên danh mục"
                />
                <small class="text-red-400">{{
                    form.errors.category_name
                }}</small>
            </div>
            <div class="grid gap-6 mb-2 md:grid-cols-2">
                <div>
                    <label
                        for="sort"
                        class="block mb-2 text-sm font-medium text-gray-900"
                        >Độ Ưu Tiên</label
                    >
                    <input
                        type="text"
                        id="sort"
                        v-model="form.sort"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Từ Cao -> Thấp"
                    />
                </div>
                <div>
                    <label
                        for="is_show"
                        class="block mb-2 text-sm font-medium text-gray-900"
                        >Trạng Thái</label
                    >
                    <select
                        id="is_show"
                        v-model="form.is_show"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    >
                        <option selected value="1">Hiện</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label
                    class="block mb-2 text-sm font-medium text-gray-900"
                    for="file_input"
                    >Upload file</label
                >
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
                    id="file_input"
                    type="file"
                    ref="fileInput"
                    @change="onChange"
                />
                <small class="text-red-400">{{
                    form.errors.category_image
                }}</small>
            </div>
            <div class="flex items-end justify-between">
                <div class="shadow-xl">
                    <img
                        v-if="imagePreview"
                        :src="imagePreview"
                        alt=""
                        class="size-20 rounded-lg object-cover"
                    />
                    <img
                        v-else-if="form.category_image"
                        :src="'/storage/' + form.category_image"
                        alt=""
                        class="size-20 rounded-lg object-cover"
                    />
                </div>
                <button
                    type="submit"
                    class="text-white text-end mt-4 max-h-10 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5"
                >
                    {{ editMode ? "Cập nhật" : "Tạo danh mục" }}
                </button>
            </div>
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
                        @onSearch="handleSearch"
                        v-model="searchQuery"
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
                            Tạo Danh Mục
                        </button>
                        <div
                            class="flex items-center space-x-3 w-full md:w-auto"
                        >
                            <!-- <div class="w-full max-w-xs mx-auto">
                                <div class="relative mt-1">
                                    <select
                                        id="category"
                                        name="category"
                                        class="block w-full pl-3 pr-10 py-2 text-base border border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                                    >
                                        <option selected>
                                            Tất cả danh mục
                                        </option>
                                        <option
                                            v-for="category in categories"
                                            :key="category.id"
                                            :value="category.id"
                                        >
                                            {{ category.category_name }}
                                        </option>
                                    </select>
                                </div>
                            </div> -->
                            <!-- <button
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
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50"
                        >
                            <tr>
                                <th scope="col" class="px-4 py-3">Ảnh</th>
                                <th scope="col" class="px-4 py-3">Danh Mục</th>
                                <th scope="col" class="px-4 py-3">Sản Phẩm</th>
                                <th scope="col" class="px-4 py-3">Ưu Tiên</th>
                                <th scope="col" class="px-4 py-3">
                                    Trạng Thái
                                </th>
                                <th scope="col" class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="border-b"
                                v-for="category in categories"
                                :key="category.id"
                            >
                                <td
                                    scope="row"
                                    class="pl-1 py-3 font-medium text-gray-900 whitespace-nowrap size-16"
                                >
                                    <img
                                        class="w-full rounded-md shadow-xl object-cover"
                                        :src="
                                            '/storage/' +
                                            category.category_image
                                        "
                                        alt="category image"
                                    />
                                </td>
                                <td class="px-4 py-3">
                                    {{ category.category_name }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ category.products_count }}
                                </td>
                                <td class="px-4 py-3">{{ category.sort }}</td>
                                <td class="px-4 py-3">
                                    {{ category.is_show ? "Hiển thị" : "Ẩn" }}
                                </td>
                                <td class="px-4 py-3 flex items-start mt-4">
                                    <div flex>
                                        <button
                                            @click="showEditCategory(category)"
                                        >
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
