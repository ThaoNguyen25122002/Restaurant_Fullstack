<script setup>
import HeaderView from "./HeaderView.vue";
import MenuView from "./MenuView.vue";
import { ref, onMounted, onUnmounted } from "vue";
import Swal from "sweetalert2";
// const count = ref;
// const ref
const toggle = ref(false);
const formatCurrency = (value) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
};
onMounted(() => {
    window.Echo.private("admin.orders").listen("OrderCreated", (event) => {
        let total = formatCurrency(event.order.total_amount);
        Swal.fire({
            title: "Có đơn đặt mới",
            text: "Giá trị đơn hàng: " + total,
            icon: "success",
        });
    });

    console.log("Listening to admin.orders channel...");
});

onUnmounted(() => {
    window.Echo.leave("admin.orders");
    console.log("Stopped listening to admin.orders channel.");
});
</script>

<template>
    <!-- Header -->
    <!-- <Header /> -->
    <HeaderView />
    <!-- End Header -->
    <!-- Menu -->
    <MenuView />
    <!-- End Menu -->
    <!-- Body -->
    <div class="p-4 sm:ml-64 mt-[64px] bg-gray-100">
        <slot />
        <!-- <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg">
        </div> -->
    </div>

    <!-- End Body  -->
</template>
