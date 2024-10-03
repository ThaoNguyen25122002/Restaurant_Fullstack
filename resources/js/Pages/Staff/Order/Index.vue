<script setup>
import { router, useForm, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { ref } from "vue";

const page = usePage();
const props = defineProps({
    orders: Array,
});
const form = useForm({
    name: page.props.auth.user.name,
    email: page.props.auth.user.email,
    phone: page.props.auth.user.phone,
});
// const status = ref(props.orders.status);
// console.log(status.value);
const updateOrderStatus = (orderId, status) => {
    router.patch(
        route("staff.order.updateStatus", { id: orderId }),
        { status },
        {
            onSuccess: (page) => {
                console.log(page);

                Swal.fire({
                    title: "Hoàn thành!",
                    text: page.props.flash.success,
                    icon: "success",
                });
            },
            preserveState: true,
            // only: ["orders"],
        }
    );
};
const updateProfile = () => {
    form.put(route("staff.profile.update", { id: page.props.auth.user.id }), {
        onSuccess: (page) => {
            Swal.fire({
                // title: "Deleted!",
                text: page.props.flash.success,
                icon: "success",
            });
        },
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
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-blue-500 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <Link :href="route('staff.orders')" class="text-2xl font-bold"
                    >Trang Nhân Viên Giao Hàng</Link
                >
                <Link
                    :href="route('staff.logout')"
                    method="post"
                    as="button"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded"
                >
                    Đăng xuất
                </Link>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto p-6 text-start">
            <!-- Thông tin cá nhân -->
            <form
                @submit.prevent="updateProfile"
                class="bg-white shadow-lg rounded-lg p-6 mb-6"
            >
                <h2 class="text-xl font-semibold mb-4">Thông tin cá nhân</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-gray-600">Tên nhân viên</label>
                        <input
                            type="text"
                            v-model="form.name"
                            class="bg-gray-100 p-2 rounded"
                        />
                    </div>
                    <div>
                        <label class="text-gray-600">Email</label>
                        <p class="bg-gray-100 p-2 rounded">
                            {{ form.email }}
                        </p>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-gray-600">Số điện thoại</label>
                        <input
                            type="text"
                            v-model="form.phone"
                            class="bg-gray-100 p-2 rounded"
                        />
                    </div>
                </div>
                <button
                    type="submit"
                    class="px-2 py-1 bg-red-500 text-white rounded-md mt-7 mx-auto block"
                >
                    Cập nhật
                </button>
            </form>

            <!-- Đơn hàng được chỉ định -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">
                    {{
                        orders.length > 0
                            ? "Đơn hàng được chỉ định để giao"
                            : "Không có đơn cần giao"
                    }}
                </h2>

                <table class="w-full table-auto" v-if="orders.length > 0">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
                            <th class="p-2 text-left">Mã đơn hàng</th>
                            <th class="p-2 text-left">Tên khách hàng</th>
                            <th class="p-2 text-left">Số điện thoại</th>
                            <th class="p-2 text-left">Địa chỉ giao hàng</th>
                            <th class="p-2 text-left">Tổng hóa đơn</th>
                            <th class="p-2 text-left">
                                Phương thức thanh toán
                            </th>
                            <th class="p-2 text-left">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="order in orders"
                            :key="order.id"
                            class="border-b"
                        >
                            <td class="p-2">{{ order.order_code }}</td>
                            <td class="p-2">{{ order.customer.name }}</td>
                            <td class="p-2">{{ order.customer.phone }}</td>
                            <td class="p-2">{{ order.delivery_address }}</td>
                            <td class="p-2">
                                {{ formatCurrency(order.total_amount) }}
                            </td>
                            <td class="p-2">
                                {{
                                    order.payment_method === "cod"
                                        ? "Thanh toán khi nhận hàng"
                                        : "Thanh toán VNPay (Đã thanh toán)"
                                }}
                            </td>
                            <td class="p-2">
                                <select
                                    v-model="order.status"
                                    @change="
                                        updateOrderStatus(
                                            order.id,
                                            order.status
                                        )
                                    "
                                    class="w-full bg-gray-100 p-2 rounded"
                                >
                                    <!-- <option value="Chờ duyệt">Chờ duyệt</option> -->
                                    <option value="Đã nhận đơn">
                                        Đã nhận đơn
                                    </option>
                                    <option value="Đang giao hàng">
                                        Đang giao hàng
                                    </option>
                                    <option value="Đã giao hàng">
                                        Đã giao hàng
                                    </option>
                                    <option value="Đã hủy">Đã hủy</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-200 text-gray-600 text-center p-4">
            © 2024 Nhà Hàng KFC
        </footer>
    </div>
</template>
