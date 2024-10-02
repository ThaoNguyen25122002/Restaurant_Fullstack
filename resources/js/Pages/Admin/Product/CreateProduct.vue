<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Swal from "sweetalert2";
defineOptions({
    layout: AdminLayout,
});

const props = defineProps({
    categories: Array,
});
console.log(props.categories);

const form = useForm({
    product_name: null,
    category_id: null,
    description: null,
    price: null,
    in_stock: 1,
    image_url: null,
    quantity: null,
    set_quantity: null,
});
const imagePreview = ref(null);
const previewImage = (event) => {
    const file = event.target.files[0];
    if (imagePreview.value) {
        URL.revokeObjectURL(imagePreview.value);
    }
    if (file && file.type.startsWith("image/")) {
        form.clearErrors("image_url");
        imagePreview.value = URL.createObjectURL(file);
        form.image_url = file;
    }
};

const submitForm = () => {
    console.log(form);
    form.post(route("admin.products.create"), {
        onSuccess: (page) => {
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
</script>

<template>
    <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">
        Tạo Sản Phẩm Mới
    </h2>
    <!-- <img src="storage/products/default.jpg" alt="asd" /> -->
    <!-- Form Container -->
    <form class="space-y-4" @submit.prevent="submitForm">
        <!-- Product Name -->
        <div class="flex items-start space-x-3">
            <div class="w-1/2">
                <label
                    class="block text-gray-700 font-semibold mb-1"
                    for="product_name"
                    >Tên Sản Phẩm</label
                >
                <input
                    id="product_name"
                    type="text"
                    class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    v-model="form.product_name"
                    placeholder="Nhập tên sản phẩm"
                />
                <small class="text-red-400">{{
                    form.errors.product_name
                }}</small>
            </div>

            <!-- Category -->
            <div class="w-1/2">
                <label
                    class="block text-gray-700 font-semibold mb-1"
                    for="category"
                    >Danh Mục</label
                >
                <select
                    v-model="form.category_id"
                    id="category"
                    class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                >
                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.category_name }}
                    </option>
                </select>
                <small class="text-red-400">{{
                    form.errors.category_id
                }}</small>
            </div>
        </div>
        <!-- Quantity and set Quantity -->
        <div class="flex items-start space-x-3">
            <div class="w-1/2">
                <label
                    class="block text-gray-700 font-semibold mb-1"
                    for="quantity"
                    >Số Lượng</label
                >
                <input
                    id="quantity"
                    type="number"
                    class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    v-model="form.quantity"
                    placeholder="Nhập số lượng"
                />
                <small class="text-red-400">{{ form.errors.quantity }}</small>
            </div>

            <!-- Set Quantity -->
            <div class="w-1/2">
                <label
                    class="block text-gray-700 font-semibold mb-1"
                    for="setQuantity"
                    >Số Lượng Mặc Định Khi Được Reset</label
                >
                <input
                    id="setQuantity"
                    type="number"
                    class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    v-model="form.set_quantity"
                    placeholder="Nhập số lượng mặc định khi được set"
                />
                <small class="text-red-400">{{
                    form.errors.set_quantity
                }}</small>
            </div>
        </div>

        <!-- Description -->
        <div>
            <label
                class="block text-gray-700 font-semibold mb-1"
                for="description"
                >Mô Tả</label
            >
            <textarea
                id="description"
                v-model="form.description"
                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                rows="3"
                placeholder="Nhập mô tả sản phẩm"
            ></textarea>
            <small class="text-red-400">{{ form.errors.description }}</small>
        </div>

        <!-- Price and Quantity -->
        <div class="flex items-start space-x-3">
            <!-- Price -->
            <div class="w-1/2">
                <label
                    class="block text-gray-700 font-semibold mb-1"
                    for="price"
                    >Giá (VND)</label
                >
                <input
                    id="price"
                    type="number"
                    v-model="form.price"
                    class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="Nhập giá sản phẩm"
                />
                <small class="text-red-400">{{ form.errors.price }}</small>
            </div>
        </div>

        <!-- Image Upload -->
        <div class="flex items-start gap-10">
            <div>
                <label
                    class="block text-gray-700 font-semibold mb-1"
                    for="image"
                    >Ảnh Sản Phẩm</label
                >
                <div class="flex space-x-3">
                    <div class="flex flex-col">
                        <input
                            id="image"
                            type="file"
                            class="px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            @change="previewImage"
                        />
                        <small class="text-red-400">{{
                            form.errors.image_url
                        }}</small>
                    </div>
                </div>
            </div>
            <!-- Image Preview -->
            <div
                v-if="imagePreview"
                class="w-24 h-24 border border-gray-300 rounded-lg overflow-hidden"
            >
                <img
                    :src="imagePreview"
                    alt="Product Image Preview"
                    class="w-full h-full object-cover"
                />
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button
                type="submit"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-500"
            >
                Tạo Sản Phẩm
            </button>
        </div>
    </form>
</template>
