<script setup>
defineProps({
    categories: Array,
});
</script>

<template>
    <div class="container">
        <div class="flex items-center pt-12 pb-7">
            <h4
                class="font-extrabold text-xl sm:text-2xl whitespace-nowrap pr-4 text-[#202124] tracking-wide uppercase"
            >
                DANH MỤC MÓN ĂN
            </h4>
            <span
                class="border w-full bg-gray-200 text-gray-100 h-[2px]"
            ></span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            <div
                class="w-full flex flex-col h-full"
                v-for="category in categories"
                :key="category.id"
            >
                <!-- Phần này chứa hình ảnh của danh mục -->
                <div class="overflow-hidden rounded-t-md flex-none">
                    <Link
                        :href="route('foods.category', { slug: category.slug })"
                    >
                        <img
                            class="w-full h-48 object-cover transition-transform duration-700 ease-in-out hover:scale-110"
                            :src="'storage/' + category.category_image"
                            alt="Ưu Đãi"
                        />
                    </Link>
                </div>

                <!-- Phần giữa, nơi chứa tiêu đề và icon -->
                <!-- Thêm lớp bg-white cho cả chiều cao còn lại và flex-grow để phần này mở rộng -->
                <div
                    class="flex items-center justify-between px-2 py-3 bg-white rounded-b-md shadow-md text-[#202124] flex-grow"
                >
                    <!-- Sử dụng truncate để tiêu đề không làm thay đổi kích thước của card -->
                    <h5 class="text-lg font-semibold">
                        {{ category.category_name }}
                    </h5>
                    <svg
                        class="w-6 h-6 text-gray-800"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m10 16 4-4-4-4"
                        />
                    </svg>
                </div>
            </div>

            <!-- <div class="max-w-64">
                <div class="overflow-hidden rounded-t-md">
                    <img
                        class="w-full object-cover transition-transform duration-700 ease-in-out hover:scale-110"
                        :src="'storage/categories/KHUYEN MAI.jpg'"
                        alt="Ưu Đãi"
                    />
                </div>
                <div
                    class="flex items-center justify-between px-2 py-3 bg-white rounded-b-md shadow-md text-[#202124]"
                >
                    <h5 class="text-lg font-semibold">Ưu Đãi</h5>
                    <svg
                        class="w-6 h-6 text-gray-800"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m10 16 4-4-4-4"
                        />
                    </svg>
                </div>
            </div> -->
        </div>
    </div>
</template>
