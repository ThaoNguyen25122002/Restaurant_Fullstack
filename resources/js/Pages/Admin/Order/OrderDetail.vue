<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
defineOptions({
    layout: AdminLayout,
});

const props = defineProps({
    orders: Object,
    staffs: Array,
});
// const status = ref(null);
const form = useForm({
    status: props.orders.status,
    staff_id: props.orders.staff_id || "",
});
console.log(form.status);

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

const updateOrderDetail = () => {
    // console.log(form.staff_id);
    // console.log(form);

    form.put(route("admin.orders.detail.update", { id: props.orders.id }), {
        onSuccess: (page) => {
            // console.log(123);
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
    <form
        @submit.prevent="updateOrderDetail"
        class="bg-white shadow-lg rounded-lg p-6"
    >
        <h2 class="text-2xl font-bold mb-6">Chi tiết đơn hàng</h2>

        <!-- Thông tin khách hàng -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Thông tin khách hàng</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-gray-600">Tên khách hàng</label>
                    <p class="bg-gray-100 p-2 rounded">
                        {{ orders.customer.name }}
                    </p>
                </div>
                <div>
                    <label class="text-gray-600">Email</label>
                    <p class="bg-gray-100 p-2 rounded">
                        {{ orders.customer.email }}
                    </p>
                </div>
                <div>
                    <label class="text-gray-600">Số điện thoại</label>
                    <p class="bg-gray-100 p-2 rounded">
                        {{ orders.customer.phone }}
                    </p>
                </div>
                <div>
                    <label class="text-gray-600">Địa chỉ giao hàng</label>
                    <p class="bg-gray-100 p-2 rounded">
                        {{ orders.delivery_address }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Thông tin đơn hàng -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Thông tin đơn hàng</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-gray-600">Trạng thái đơn hàng</label>
                    <select
                        v-model="form.status"
                        class="w-full bg-gray-100 p-2 rounded"
                    >
                        <option value="Chờ duyệt">Chờ duyệt</option>
                        <option value="Đã nhận đơn">Đã nhận đơn</option>
                        <option value="Đang giao hàng">Đang giao hàng</option>
                        <option value="Đã giao hàng">Đã giao hàng</option>
                        <option value="Đã đánh giá">Đã đánh giá</option>
                        <option value="Đã hủy">Đã hủy</option>
                    </select>
                    <small class="text-red-500">{{ form.errors.status }}</small>
                </div>
                <div>
                    <label class="text-gray-600">Nhân viên giao hàng</label>
                    <select
                        v-model="form.staff_id"
                        :disabled="form.status === 'Chờ duyệt'"
                        class="w-full bg-gray-100 p-2 rounded disabled:opacity-30"
                    >
                        <option value="">Chọn nhân viên giao hàng</option>
                        <option
                            v-for="staff in staffs"
                            :key="staff.id"
                            :value="staff.id"
                        >
                            {{ staff.name }}
                        </option>
                    </select>
                    <small class="text-red-500">{{
                        form.errors.staff_id
                    }}</small>
                </div>
                <div>
                    <label class="text-gray-600">Phương thức thanh toán</label>
                    <p class="bg-gray-100 p-2 rounded">
                        {{
                            orders.payment_method === "cod"
                                ? "Thanh toán khi nhận hàng (COD)"
                                : "Thanh toán VNPay (Đã thanh toán)"
                        }}
                    </p>
                </div>
                <div>
                    <label class="text-gray-600">Thời gian đặt hàng</label>
                    <p class="bg-gray-100 p-2 rounded">
                        {{ formattedDate(orders.created_at) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Thông tin chi tiết sản phẩm -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Thông tin đơn hàng</h3>
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
                        <th class="p-2 text-left">Tên món</th>
                        <th class="p-2 text-left">Số lượng</th>
                        <th class="p-2 text-left">Giá</th>
                        <th class="p-2 text-left">Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="item in orders.order_items"
                        :key="item.id"
                        class="border-b"
                    >
                        <td class="p-2">{{ item.product.product_name }}</td>
                        <td class="p-2">{{ item.quantity }}</td>
                        <td class="p-2">{{ formatCurrency(item.price) }}</td>
                        <td class="p-2">
                            {{ formatCurrency(item.price * item.quantity) }}
                        </td>
                    </tr>

                    <tr class="font-bold">
                        <td class="p-2">Tổng cộng</td>
                        <td></td>
                        <td></td>
                        <td class="p-2">
                            {{ formatCurrency(orders.total_amount) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Nút lưu thay đổi -->
        <div class="flex justify-end">
            <button
                type="submit"
                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded"
            >
                Cập nhật đơn
            </button>
        </div>
    </form>
</template>
