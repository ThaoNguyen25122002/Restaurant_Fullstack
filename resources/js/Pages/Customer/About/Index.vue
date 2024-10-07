<script setup>
import CustomerLayout from "../../../Layouts/Customer/CustomerLayout.vue";
defineOptions({
    layout: CustomerLayout,
});
</script>

<template>
    <div class="bg-gray-100 text-gray-800 mt-[72px]">
        <header class="bg-red-600 text-white p-6">
            <h1 class="text-3xl font-bold text-center">Giới Thiệu</h1>
        </header>

        <section class="py-12 px-6 bg-white">
            <div class="container mx-auto text-center">
                <h2 class="text-2xl font-semibold text-red-600">
                    Về Chúng Tôi
                </h2>
                <p class="mt-4 text-gray-700 leading-relaxed">
                    Chúng tôi là hệ thống đặt và giao đồ ăn hàng đầu, mang đến
                    cho khách hàng trải nghiệm ẩm thực tuyệt vời với đa dạng món
                    ăn từ các nhà hàng yêu thích. Với đội ngũ giao hàng chuyên
                    nghiệp, chúng tôi cam kết giao hàng nhanh chóng và đảm bảo
                    chất lượng.
                </p>
            </div>
        </section>

        <section class="py-12 px-6 bg-gray-50">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <img
                            :src="'/storage/about/about.jpg'"
                            alt="Về chúng tôi"
                            class="w-full h-80 object-cover rounded-lg shadow-lg"
                        />
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-xl font-semibold text-red-600">
                            Sứ mệnh của chúng tôi
                        </h3>
                        <p class="mt-4 text-gray-700">
                            Chúng tôi mong muốn kết nối người tiêu dùng với các
                            món ăn ngon nhất từ mọi nơi, mang đến sự tiện lợi và
                            thỏa mãn nhu cầu thưởng thức ẩm thực của bạn chỉ với
                            một vài cú nhấp chuột.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-red-600 text-white py-6 text-center">
            <p>&copy; 2024 Đặt Và Giao Đồ Ăn. Tất cả các quyền được bảo lưu.</p>
        </footer>
    </div>
</template>
