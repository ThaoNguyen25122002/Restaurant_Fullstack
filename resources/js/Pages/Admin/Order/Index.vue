<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import Swal from "sweetalert2";
import PaginationLinks from "../../../components/Common/PaginationLinks.vue";
import FormSearch from "@/components/Admin/FormSearch/Index.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import { watch } from "vue";
defineOptions({
    layout: AdminLayout,
});
const props = defineProps({
    orders: Object,
    searchTerm: String,
    statusTerm: String,
});
const selectedStatus = ref(props.statusTerm || "");
const searchQuery = ref(props.searchTerm || "");
// console.log(props.orders);
const formattedDate = (createdAt) => {
    const date = new Date(createdAt); // Chuyển string thành Date object
    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0"); // Tháng bắt đầu từ 0 nên cần +1
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, "0");
    const minutes = String(date.getMinutes()).padStart(2, "0");

    return `${day}/${month}/${year} - ${hours}:${minutes}`; // Định dạng DD/MM/YYYY HH:mm
};
const handleSearch = () => {
    // console.log(value);
    if (
        searchQuery.value === props.searchTerm ||
        searchQuery.value.trim() === ""
    ) {
        return;
    }
    // console.log(searchQuery.value);
    router.get(
        route("admin.orders"),
        {
            search: searchQuery.value,
        },
        {
            preserveState: true,
            replace: true,
            only: ["orders"],
        }
    );
};
watch(selectedStatus, (newValue) => {
    // console.log(newValue);
    router.get(
        route("admin.orders"),
        {
            status: newValue,
        },
        {
            preserveState: true,
            replace: true,
        }
    );
});
</script>
<template>
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
                        <div
                            class="flex items-center space-x-3 w-full md:w-auto"
                        >
                            <div class="w-full max-w-xs mx-auto">
                                <div class="relative mt-1">
                                    <select
                                        id="category"
                                        name="category"
                                        v-model="selectedStatus"
                                        class="block w-full pl-3 pr-10 py-2 text-base border border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                                    >
                                        <option value="">Tất cả</option>
                                        <option value="Chờ duyệt" selected>
                                            Chờ duyệt
                                        </option>
                                        <option value="Đã nhận đơn">
                                            Đã nhận đơn
                                        </option>
                                        <option value="Đang giao hàng">
                                            Đang giao hàng
                                        </option>
                                        <option value="Đã giao hàng">
                                            Đã giao hàng
                                        </option>
                                        <option value="Đã đánh giá">
                                            Đã đánh giá
                                        </option>
                                        <option value=" Đã hủy">Đã hủy</option>
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
                                <th scope="col" class="px-4 py-3">
                                    Mã Đơn Hàng
                                </th>
                                <th scope="col" class="px-4 py-3">Người Đặt</th>
                                <th scope="col" class="px-4 py-3">Ngày Đặt</th>
                                <th scope="col" class="px-4 py-3">
                                    Trạng Thái
                                </th>
                                <th scope="col" class="px-4 py-3">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="border-b"
                                v-for="order in orders.data"
                                :key="order.id"
                            >
                                <th
                                    scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    {{ order.order_code }}
                                </th>
                                <td class="px-4 py-3">
                                    {{ order.customer.name }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ formattedDate(order.created_at) }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ order.status }}
                                </td>
                                <td class="px-4">
                                    <Link
                                        :href="
                                            route('admin.orders.detail', {
                                                id: order.id,
                                            })
                                        "
                                        class="px-2 py-1 bg-red-600 text-white rounded-md"
                                    >
                                        Xem
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <pagination-links :paginator="orders" />
</template>
