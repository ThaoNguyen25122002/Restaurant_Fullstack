<script setup>
import { router, useForm } from "@inertiajs/vue3";
import CustomerLayout from "../../../Layouts/Customer/CustomerLayout.vue";
import Swal from "sweetalert2";
import { ref } from "vue";
defineOptions({
    layout: CustomerLayout,
});
const props = defineProps({
    orders: Array,
});
const formattedDate = (createdAt) => {
    const date = new Date(createdAt); // Chuyển string thành Date object
    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0"); // Tháng bắt đầu từ 0 nên cần +1
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, "0");
    const minutes = String(date.getMinutes()).padStart(2, "0");

    return `${day}/${month}/${year} - ${hours}:${minutes}`; // Định dạng DD/MM/YYYY HH:mm
};
const formatCurrency = (value) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
};

const getOrderBadgeClass = (status) => {
    switch (status) {
        case "Đang giao hàng":
            return "bg-green-600 text-white";
        case "Chờ duyệt":
            return "bg-red-600 text-white";
        case "Đã gray hàng":
            return "bg-green-600 text-white";
        case "Đã hủy":
            return "bg-gray-600 text-white";
        case "Đã đánh giá":
            return "bg-red-400 text-white";
        default:
            return "bg-gray-600 text-white";
    }
};

const handleDelete = (orderId) => {
    // console.log(orderId);
    Swal.fire({
        title: "Bạn muốn hủy đơn?",
        // text: "Bạn không thể khôi phục nếu xóa!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route("orders.delete", { id: orderId }), {
                onSuccess: (page) => {
                    Swal.fire({
                        title: page.props.flash.success,
                        // text: page.props.flash.success,
                        icon: "success",
                    });
                },
                onError: (error) => {
                    Swal.fire({
                        title: "Không Thể Hủy",
                        text: error[0],
                        icon: "error",
                    });
                },
                preserveScroll: true,
            });
        }
    });
};
const handleRepurchase = (orderId) => {
    Swal.fire({
        title: "Bạn muốn mua lại?",
        // text: "Bạn không thể khôi phục nếu xóa!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
    }).then((result) => {
        if (result.isConfirmed) {
            router.post(route("cart.repurchase", { id: orderId }), {
                onSuccess: (page) => {
                    Swal.fire({
                        title: page.props.flash.success,
                        // text: page.props.flash.success,
                        icon: "success",
                    });
                },
                onError: (error) => {
                    Swal.fire({
                        title: "Không Thể Hủy",
                        text: error[0],
                        icon: "error",
                    });
                },
                preserveScroll: true,
            });
        }
    });
};
const dialogVisible = ref(false);

const handleReview = (items, orderId) => {
    // console.log(items);
    formReview.orderId = orderId;
    formReview.productIds = items.map((item) => item.product_id);
    console.log(formReview);

    dialogVisible.value = true;
};
const formReview = useForm({
    orderId: null,
    rating: null,
    review: null,
    productIds: [],
});
const rating = ref(0); // Điểm rating hiện tại
const hoverRating = ref(0); // Điểm rating khi di chuột qua các ngôi sao
const review = ref("");

const setRating = (star) => {
    rating.value = star;
};

const submitReview = () => {
    (formReview.rating = rating.value), (formReview.review = review.value);
    formReview.post(route("reviews.create", { id: formReview.orderId }), {
        onSuccess: (page) => {
            Swal.fire({
                title: page.props.flash.success,
                // text: page.props.flash.success,
                icon: "success",
            });
            handleClose();
        },
    });
    console.log(formReview);
};
const handleClose = () => {
    formReview.clearErrors();
    formReview.reset();
    rating.value = 0;
    hoverRating.value = 0;
    review.value = "";
    dialogVisible.value = false;
};
</script>

<template>
    <!-- Dialog Form Create or Edit User -->

    <el-dialog v-model="dialogVisible" width="500" :before-close="handleClose">
        <!-- Form -->

        <form
            @submit.prevent="submitReview"
            class="flex flex-col items-center justify-center bg-gray-100"
        >
            <!-- Rating Section -->
            <div class="bg-white rounded-lg p-6 w-full">
                <h1 class="text-2xl font-semibold text-gray-700 mb-4">
                    Đánh giá đơn hàng
                </h1>

                <!-- Rating Stars -->
                <div class="flex items-center mb-6">
                    <span
                        v-for="star in 5"
                        :key="star"
                        @click="setRating(star)"
                        @mouseover="hoverRating = star"
                        @mouseleave="hoverRating = 0"
                        class="cursor-pointer text-gray-400"
                    >
                        <svg
                            v-if="star <= (hoverRating || rating)"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            class="w-8 h-8 text-yellow-500"
                        >
                            <path
                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"
                            />
                        </svg>
                        <svg
                            v-else
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            class="w-8 h-8"
                        >
                            <path
                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"
                            />
                        </svg>
                    </span>
                    <small class="text-red-500 block">{{
                        formReview.errors.rating
                    }}</small>
                </div>

                <!-- Review Section -->
                <small class="text-red-500">{{
                    formReview.errors.review
                }}</small>
                <textarea
                    v-model="review"
                    class="w-full border border-gray-300 rounded-lg p-3 mb-4"
                    rows="5"
                    placeholder="Viết nhận xét của bạn..."
                ></textarea>

                <!-- Submit Button -->
                <button
                    class="bg-red-600 text-white font-bold py-2 px-4 rounded hover:bg-red-700 w-full"
                >
                    Gửi đánh giá
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
    <div class="min-h-screen flex flex-col mt-[72px]">
        <!-- Main Content -->
        <main class="flex-grow container mx-auto p-6" v-if="orders.length > 0">
            <h2 class="text-xl font-semibold mb-6 text-red-600">
                Danh Sách Đơn Hàng
            </h2>

            <!-- Order List -->
            <div class="grid grid-cols-1 gap-6">
                <!-- Order Card -->
                <div
                    v-for="order in orders"
                    :key="order.id"
                    class="bg-white shadow-md rounded-lg overflow-hidden"
                >
                    <div class="p-4 flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="text-red-600 font-bold text-lg">
                                #{{ order.order_code }}
                            </div>
                            <div class="ml-4 text-gray-600">
                                Ngày đặt: {{ formattedDate(order.created_at) }}
                            </div>
                        </div>
                        <div
                            :class="getOrderBadgeClass(order.status)"
                            class="text-xs px-1 md:text-base md:px-3 py-1 rounded-full"
                        >
                            {{ order.status }}
                        </div>
                    </div>

                    <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Customer Info -->
                        <div>
                            <h3 class="text-gray-600 font-semibold mb-2">
                                Thông tin khách hàng
                            </h3>
                            <p>Tên: {{ order.customer.name }}</p>
                            <p>Số điện thoại: {{ order.customer.phone }}</p>
                            <p>Địa chỉ: {{ order.customer.address }}</p>
                        </div>

                        <!-- Order Details -->
                        <div>
                            <h3 class="text-gray-600 font-semibold mb-2">
                                Chi tiết đơn hàng
                            </h3>
                            <p class="">
                                Phương thức thanh toán:
                                {{
                                    order.payment_method == "cod"
                                        ? "Thanh toán khi nhận đơn"
                                        : "Thanh toán VNPay"
                                }}
                            </p>
                            <p v-for="item in order.order_items" :key="item.id">
                                {{ item.product.product_name }} -
                                {{ item.quantity }} phần
                            </p>

                            <div
                                class="mt-2"
                                v-if="
                                    order.total_amount !=
                                    order.original_total_amount
                                "
                            >
                                <p>
                                    Tổng đơn:
                                    <span class="font-bold">{{
                                        formatCurrency(
                                            order.original_total_amount
                                        )
                                    }}</span>
                                </p>
                                <p>
                                    Voucher:
                                    <span class="font-bold">
                                        {{
                                            formatCurrency(
                                                order.original_total_amount -
                                                    order.total_amount
                                            )
                                        }}
                                    </span>
                                </p>
                            </div>
                            <p class="font-bold mt-2">
                                Thành tiền:
                                {{ formatCurrency(order.total_amount) }}
                            </p>
                        </div>

                        <!-- Delivery Staff Info -->
                        <div v-if="order.staff">
                            <h3 class="text-gray-600 font-semibold mb-2">
                                Thông tin nhân viên giao hàng
                            </h3>
                            <p>Tên: {{ order.staff.name }}</p>
                            <p>Số điện thoại: {{ order.staff.phone }}</p>
                        </div>
                    </div>

                    <div class="bg-gray-100 p-4 flex justify-end items-center">
                        <!-- <button class="text-red-600 hover:underline">
                            Xem chi tiết
                        </button> -->
                        <button
                            v-if="order.status === 'Đã giao hàng'"
                            @click="handleReview(order.order_items, order.id)"
                            class="bg-red-600 text-white font-bold py-2 px-4 rounded hover:bg-red-700"
                        >
                            Đánh giá
                        </button>
                        <button
                            v-else-if="order.status === 'Đã đánh giá'"
                            @click="handleRepurchase(order.id)"
                            class="bg-gray-600 text-white font-bold py-2 px-4 rounded hover:bg-gray-700"
                        >
                            Mua lại
                        </button>
                        <button
                            v-else
                            @click="handleDelete(order.id)"
                            class="bg-gray-600 text-white font-bold py-2 px-4 rounded hover:bg-gray-700"
                        >
                            Hủy đơn
                        </button>
                    </div>
                </div>
            </div>
        </main>

        <h4 v-else class="text-2xl font-bold text-red-300 text-center mt-10">
            Hiện bạn không có đơn hàng nào!
        </h4>
    </div>
</template>
