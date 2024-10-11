<script setup>
import Navbar from "./Navbar.vue";
import Footer from "./Footer.vue";
</script>
<template>
    <div
        class="w-full min-h-screen bg-neutral-100/50 text-neutral-500 flex flex-col"
    >
        <!-- Navbar -->
        <Navbar />
        <!-- End Navbar -->
        <!-- Main Content -->
        <slot />
        <!-- End Main Content -->
        <!-- Footer -->
        <Footer />
        <!-- End Footer -->
        <!-- Chat Box AI -->
        <df-messenger
            intent="WELCOME"
            chat-title="Hỗ trợ khách hàng"
            agent-id="c823f962-1cd7-41bf-884a-cbd6fd1f861b"
            language-code="vi"
        ></df-messenger>
    </div>
</template>
