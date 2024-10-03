<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";

const page = usePage();

const form = useForm({
    name: page.props.auth.user.name,
    email: page.props.auth.user.email,
    phone: page.props.auth.user.phone,
});

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
                    Đơn hàng được chỉ định để giao
                </h2>
                <table class="w-full table-auto">
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
                        <tr class="border-b">
                            <td class="p-2">#123456</td>
                            <td class="p-2">Nguyễn Văn A</td>
                            <td class="p-2">0123 456 789</td>
                            <td class="p-2">123 Đường ABC, TP.HCM</td>
                            <td class="p-2">318.000 VND</td>
                            <td class="p-2">
                                Thanh toán VNPay (Đã thanh toán)
                            </td>
                            <td class="p-2">
                                <select class="w-full bg-gray-100 p-2 rounded">
                                    <option>Đã nhận đơn</option>
                                    <option>Đang giao hàng</option>
                                    <option>Đã giao hàng</option>
                                    <option>Đã hủy</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-2">#123456</td>
                            <td class="p-2">Nguyễn Văn A</td>
                            <td class="p-2">0123 456 789</td>
                            <td class="p-2">123 Đường ABC, TP.HCM</td>
                            <td class="p-2">318.000 VND</td>
                            <td class="p-2">Thanh toán khi nhận hàng</td>
                            <td class="p-2">
                                <select class="w-full bg-gray-100 p-2 rounded">
                                    <option>Đã nhận đơn</option>
                                    <option>Đang giao hàng</option>
                                    <option>Đã giao hàng</option>
                                    <option>Đã hủy</option>
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
