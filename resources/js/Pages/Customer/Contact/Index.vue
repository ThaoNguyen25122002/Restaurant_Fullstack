<script setup>
import CustomerLayout from "../../../Layouts/Customer/CustomerLayout.vue";
defineOptions({
    layout: CustomerLayout,
});
</script>

<template>
    <div class="bg-gray-100 text-gray-800 mt-[72px]">
        <header class="bg-red-600 text-white p-6">
            <h1 class="text-3xl font-bold text-center">Liên Hệ</h1>
        </header>

        <section class="py-12 px-6 bg-white">
            <div class="container mx-auto text-center">
                <h2 class="text-2xl font-semibold text-red-600">
                    Chúng tôi ở đây để giúp đỡ bạn
                </h2>
                <p class="mt-4 text-gray-700 leading-relaxed">
                    Nếu bạn có bất kỳ câu hỏi hoặc cần hỗ trợ, hãy liên hệ với
                    chúng tôi qua các thông tin dưới đây.
                </p>
            </div>
        </section>

        <section class="py-12 px-6 bg-gray-50">
            <div
                class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-8"
            >
                <!-- Thông tin liên hệ -->
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-red-600 mb-4">
                        Thông tin liên hệ
                    </h3>
                    <ul class="space-y-4 text-gray-700">
                        <li>
                            <strong>Địa chỉ:</strong> 123 Đường ABC, Quận Thanh
                            Khê, Đà Nẵng
                        </li>
                        <li>
                            <strong>Email:</strong>
                            <a
                                href="mailto:contact@fooddelivery.com"
                                class="text-red-600 underline"
                                >contact@fooddelivery.com</a
                            >
                        </li>
                        <li>
                            <strong>Số điện thoại:</strong>
                            <a
                                href="tel:+84901234567"
                                class="text-red-600 underline"
                                >+84 901 234 567</a
                            >
                        </li>
                        <li><strong>Fanpage:</strong></li>
                        <ul class="ml-6 space-y-2">
                            <li>
                                <a
                                    href="https://facebook.com/fooddelivery"
                                    class="text-red-600 underline"
                                    >Facebook</a
                                >
                            </li>
                            <li>
                                <a
                                    href="https://instagram.com/fooddelivery"
                                    class="text-red-600 underline"
                                    >Instagram</a
                                >
                            </li>
                            <li>
                                <a
                                    href="https://twitter.com/fooddelivery"
                                    class="text-red-600 underline"
                                    >Twitter</a
                                >
                            </li>
                        </ul>
                    </ul>
                </div>

                <!-- Form liên hệ -->
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <form action="#" method="POST">
                        <div class="mb-6">
                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700"
                                >Họ tên</label
                            >
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="mt-2 p-3 block w-full border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                                required
                            />
                        </div>

                        <div class="mb-6">
                            <label
                                for="email"
                                class="block text-sm font-medium text-gray-700"
                                >Email</label
                            >
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="mt-2 p-3 block w-full border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                                required
                            />
                        </div>

                        <div class="mb-6">
                            <label
                                for="message"
                                class="block text-sm font-medium text-gray-700"
                                >Nội dung liên hệ</label
                            >
                            <textarea
                                id="message"
                                name="message"
                                rows="4"
                                class="mt-2 p-3 block w-full border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                                required
                            ></textarea>
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-red-600 text-white p-3 rounded-lg hover:bg-red-700"
                        >
                            Gửi Liên Hệ
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <footer class="bg-red-600 text-white py-6 text-center">
            <p>&copy; 2024 Đặt Và Giao Đồ Ăn. Tất cả các quyền được bảo lưu.</p>
        </footer>
    </div>
</template>
