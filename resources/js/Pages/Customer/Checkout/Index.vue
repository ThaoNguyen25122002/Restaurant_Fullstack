<script setup>
import CustomerLayout from "../../../Layouts/Customer/CustomerLayout.vue";
import Swal from "sweetalert2";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
const props = defineProps({
    carts: Array,
});
const page = usePage();
const note = ref(null);

defineOptions({
    layout: CustomerLayout,
});
const totalPrice = computed(() => {
    return props.carts.reduce(
        (total, item) => total + item.quantity * item.product.price,
        0
    );
});
// const form = useForm({
//     coupon_id: null,
//     original_total_amount: null,
//     payment_method: "cod",
//     delivery_address: page.props.auth.user.address,
//     note: null,
//     total_amount: totalPrice,
// });
// Tạo form sử dụng useForm
const form = useForm({
    coupon_id: null,
    original_total_amount: ref(totalPrice.value), // Khởi tạo dưới dạng ref
    payment_method: "cod",
    delivery_address: page.props.auth.user.address,
    note: null,
    total_amount: ref(totalPrice.value), // Sử dụng ref để có thể cập nhật giá trị
});
const coupon = useForm({
    code: null,
});

const handleApplyCoupon = () => {
    coupon.post(route("customer.coupons.apply"), {
        onSuccess: (page) => {
            const discountPercentage =
                page.props.flash.success.discount_percentage;

            form.original_total_amount = totalPrice.value;

            form.total_amount =
                totalPrice.value * (1 - discountPercentage / 100);

            form.coupon_id = page.props.flash.success.id;
            Swal.fire({
                // title: "Không Thể Áp Dụng",
                text:
                    "Đã áp dụng mã giảm " +
                    page.props.flash.success.discount_percentage +
                    "%",
                icon: "success",
            });
            console.log(form);
        },
        onError: (error) => {
            Swal.fire({
                title: "Không Thể Áp Dụng",
                text: error[0],
                icon: "error",
            });
        },
        preserveScroll: true,
        preserveState: true,
    });
};

const handleCheckout = () => {
    // console.log(paymentMethod.value);
    // console.log(form);
    Swal.fire({
        title: "Chắc chắn?",
        text: "Kiểm tra đúng thông tin trước khi đặt!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sure!",
    }).then((result) => {
        if (result.isConfirmed) {
            if (form.payment_method === "cod") {
                console.log("thanh toan khi nhan hang");
                form.post(route("payment.cod"), {
                    onSuccess: (page) => {
                        Swal.fire({
                            toast: true,
                            icon: "success",
                            position: "top-end",
                            showConfirmButton: false,
                            text: page.props.flash.success,
                            timer: 2000,
                        });
                    },
                });
            } else if (form.payment_method === "vnpay") {
                console.log("thanh toan VNPay");
                form.post(route("payment.vnpay"), {
                    onSuccess: (page) => {
                        // console.log(page.props);
                        if (page.props.flash.success) {
                            window.location.href = page.props.flash.success;
                        }
                    },
                    onError: (page) => {
                        Swal.fire({
                            toast: true,
                            icon: "error",
                            position: "top-end",
                            showConfirmButton: false,
                            text: page.props.flash.error,
                            timer: 2000,
                        });
                    },
                });
            }
        }
    });
};
const formatCurrency = (value) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
};
</script>

<template>
    <!-- Main Container -->
    <div class="container mx-auto p-6 mt-[20px]">
        <!-- Breadcrumbs -->
        <nav class="text-sm mb-6">
            <ol class="flex items-center space-x-4">
                <li><a href="#" class="text-gray-500">Giỏ Hàng</a></li>
                <li class="text-gray-500">&rarr;</li>
                <li class="text-red-500">Đặt Hàng</li>
                <li class="text-gray-500">&rarr;</li>
                <li class="text-gray-500">Hoàn Thành Đơn Hàng</li>
            </ol>
        </nav>

        <!-- Checkout Form -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Shipping Address -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Địa Chỉ Giao Hàng</h2>

                <form action="#">
                    <div class="mb-4">
                        <label class="block text-gray-700">Họ Và Tên</label>
                        <input
                            type="text"
                            :value="$page.props.auth.user.name"
                            class="w-full border border-gray-300 rounded-lg p-2"
                            placeholder="..."
                            disabled
                        />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Số Điện Thoại</label>
                        <input
                            type="text"
                            :value="$page.props.auth.user.phone"
                            disabled
                            class="w-full border border-gray-300 rounded-lg p-2"
                            placeholder="..."
                        />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Nhập địa chỉ </label>
                        <input
                            type="text"
                            v-model="form.delivery_address"
                            class="w-full border border-gray-300 rounded-lg p-2"
                            placeholder="..."
                        />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700"
                            >Ghi Chú Đơn Hàng</label
                        >
                        <textarea
                            v-model="form.note"
                            class="w-full border border-gray-300 rounded-lg p-2"
                            placeholder="Ghi chú..."
                        ></textarea>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Đơn Hàng</h2>

                <div class="border-b border-gray-200 pb-4 mb-4">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-700">Tạm Tính</span>
                        <span class="text-gray-700">{{
                            formatCurrency(form.original_total_amount)
                        }}</span>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <input
                            type="text"
                            class="w-1/2 border border-gray-300 rounded-lg p-2"
                            placeholder="Mã giảm giá"
                            v-model="coupon.code"
                        />
                        <button
                            class="ml-2 bg-red-500 text-white px-4 py-2 rounded-lg"
                            @click="handleApplyCoupon"
                        >
                            Áp dụng
                        </button>
                    </div>
                    <small class="text-red-500">{{ coupon.errors.code }}</small>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-700">Giảm Giá</span>
                        <span class="text-gray-700">{{
                            form.original_total_amount != form.total_amount
                                ? formatCurrency(
                                      form.original_total_amount -
                                          form.total_amount
                                  )
                                : "0đ"
                        }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-700">Phí Vận Chuyển</span>
                        <span class="text-gray-700">Miễn Phí</span>
                    </div>
                    <div class="flex justify-between items-center mb-2 mt-5">
                        <span class="text-black font-semibold text-lg"
                            >Phương thức thanh toán:</span
                        >
                        <!-- <span class="text-gray-700"
                            >Thanh toán khi nhận hàng</span
                        > -->
                        <select
                            v-model="form.payment_method"
                            class="text-gray-700 border px-3 py-1 rounded-sm"
                        >
                            <option value="cod">
                                Thanh toán khi nhận hàng
                            </option>
                            <option value="vnpay">Thanh toán VNPay</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-between mb-4">
                    <span class="text-red-500 font-bold text-lg"
                        >Tổng Tiền</span
                    >
                    <span class="text-red-500 font-bold text-lg">{{
                        formatCurrency(form.total_amount)
                    }}</span>
                </div>

                <button
                    @click="handleCheckout"
                    class="w-full bg-red-500 text-white py-3 rounded-lg"
                >
                    Hoàn Thành Đơn Hàng
                </button>
            </div>
        </div>
        <div class="bg-white mt-6 p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Chi Tiết Sản Phẩm</h2>

            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="text-left py-2 px-4 border-b-2">STT</th>
                        <th class="text-left py-2 px-4 border-b-2">Ảnh</th>
                        <th class="text-left py-2 px-4 border-b-2">Sản Phẩm</th>
                        <th class="text-left py-2 px-4 border-b-2">Giá</th>
                        <th class="text-left py-2 px-4 border-b-2">Số Lượng</th>
                        <th class="text-left py-2 px-4 border-b-2">
                            Thành Tiền
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="border-b"
                        v-for="(item, index) in carts"
                        :key="item.id"
                    >
                        <td class="py-4 px-4">{{ index + 1 }}</td>
                        <td class="py-4 px-4">
                            <img
                                :src="'storage/' + item.product.image_url"
                                alt="product"
                                class="w-16 h-16 object-cover"
                            />
                        </td>
                        <td class="py-4 px-4">
                            {{ item.product.product_name }}<br />
                        </td>
                        <td class="py-4 px-4">
                            {{ formatCurrency(item.product.price) }}
                        </td>
                        <td class="py-4 px-4">{{ item.quantity }}</td>
                        <td class="py-4 px-4">
                            {{
                                formatCurrency(
                                    item.product.price * item.quantity
                                )
                            }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
