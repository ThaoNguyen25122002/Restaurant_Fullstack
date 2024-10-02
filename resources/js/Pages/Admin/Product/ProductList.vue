<script setup>
import { router, useForm } from "@inertiajs/vue3";
import { ref, watch, watchEffect } from "vue";
import Swal from "sweetalert2";
import FormSearch from "@/components/Admin/FormSearch/Index.vue";
const props = defineProps({
    products: Object,
    searchTerm: String,
    categoryTerm: String,
    categories: Array,
});
const searchQuery = ref(props.searchTerm || "");
// console.log(props.products);
const selectedCategories = ref(props.categoryTerm || "");
const handleDelete = (productId) => {
    Swal.fire({
        title: "Bạn muốn xóa?",
        text: "Bạn không thể khôi phục nếu xóa!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route("admin.products.delete", { id: productId }), {
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
const resetQuantity = () => {
    Swal.fire({
        title: "Bạn muốn reset số lượng tất cả các món?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Reset",
    }).then((result) => {
        if (result.isConfirmed) {
            router.post(
                route("admin.products.setQuantity"),
                {},
                {
                    onSuccess: (page) => {
                        console.log(123);
                        Swal.fire({
                            toast: true,
                            icon: "success",
                            position: "top-end",
                            showConfirmButton: false,
                            title: page.props.flash.success,
                            timer: 1500,
                        });
                    },
                }
            );
        }
    });
};
const handleSearch = (value) => {
    // console.log(value);
    if (searchQuery.value === props.searchTerm) {
        return;
    }
    console.log(123);
    router.get(
        route("admin.products"),
        {
            search: searchQuery.value,
        },
        {
            preserveState: true,
            replace: true,
            only: ["products"],
        }
    );
};
watch(selectedCategories, (newValue) => {
    router.get(
        route("admin.products"),
        {
            category: newValue,
        },
        {
            preserveState: true,
            replace: true,
        }
    );
});

// const filteredProducts = () => {
//     router.get(route("admin.products.filterCategoryProducts"), {
//         category: selectedCategories.value,
//     });
// };
const formatCurrency = (value) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
};
// const testClick = () => {
//     Swal.fire({
//         title: "Are you sure?",
//         text: "You won't be able to revert this!",
//         icon: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#3085d6",
//         cancelButtonColor: "#d33",
//         confirmButtonText: "Yes, delete it!",
//     }).then((result) => {
//         if (result.isConfirmed) {
//             Swal.fire({
//                 title: "Deleted!",
//                 text: "Your file has been deleted.",
//                 icon: "success",
//             });
//         }
//     });
// };
</script>

<template>
    <!-- <img
        src="http://127.0.0.1:8000/storage/products/default.jpg"
        alt="Product Image"
    /> -->
    <section class="bg-gray-50">
        <div class="mx-auto max-w-screen">
            <!-- Start coding here -->
            <div
                class="bg-white relative shadow-md sm:rounded-lg overflow-hidden"
            >
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4"
                >
                    <FormSearch
                        v-model="searchQuery"
                        @onSearch="handleSearch"
                    />
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0"
                    >
                        <button
                            @click="resetQuantity"
                            class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none"
                        >
                            Reset số lượng
                        </button>
                        <Link
                            :href="route('admin.products.create')"
                            type="button"
                            class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none"
                        >
                            Thêm món mới
                        </Link>
                        <div
                            class="flex items-center space-x-3 w-full md:w-auto"
                        >
                            <div class="w-full max-w-xs mx-auto">
                                <div class="relative mt-1">
                                    <select
                                        id="category"
                                        name="category"
                                        v-model="selectedCategories"
                                        class="block w-full pl-3 pr-10 py-2 text-base border border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                                    >
                                        <option selected value="">
                                            Tất cả danh mục
                                        </option>
                                        <option
                                            v-for="category in categories"
                                            :key="category.id"
                                            :value="category.slug"
                                        >
                                            {{ category.category_name }}
                                        </option>
                                    </select>
                                </div>
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
                                <th scope="col" class="px-4 py-3">Ảnh</th>
                                <th scope="col" class="px-4 py-3">Tên món</th>
                                <th scope="col" class="px-4 py-3">Giá</th>
                                <th scope="col" class="px-4 py-3">
                                    Thuộc danh mục
                                </th>
                                <th scope="col" class="px-4 py-3">Số lượng</th>
                                <th scope="col" class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="border-b"
                                v-for="product in products.data"
                                :key="product.id"
                            >
                                <th class="rounded-sm ml-3 py-2 pl-2">
                                    <img
                                        :src="'/storage/' + product.image_url"
                                        alt="avatar"
                                        class="size-16 object-cover rounded-xl shadow-xl"
                                    />
                                </th>
                                <td class="px-4 py-3">
                                    {{ product.product_name }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ formatCurrency(product.price) }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ product.category.category_name }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ product.quantity }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <Link
                                            :href="
                                                route('admin.products.edit', {
                                                    id: product.id,
                                                })
                                            "
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
                                        </Link>
                                        <button
                                            @click="handleDelete(product.id)"
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
