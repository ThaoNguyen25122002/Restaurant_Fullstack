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
    </div>
</template>
