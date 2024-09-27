<script setup></script>

<template>
    <div class="p-2 bg-white shadow-sm rounded-lg flex flex-col h-full">
        <div class="overflow-hidden w-full rounded-md">
            <img
                class="w-full object-cover transition-transform duration-700 ease-in-out hover:scale-110"
                :src="'storage/products/1727235543_66f385d7221d7.jpg'"
                alt="Ưu Đãi"
            />
        </div>
        <div class="flex-grow pt-3 pb-2 px-3 flex flex-col justify-between">
            <div>
                <div
                    class="flex items-start justify-between text-lg font-semibold text-gray-800"
                >
                    <h6 class="w-40">Combo nhóm 2</h6>
                    <p class="text-orange-500">127.000đ</p>
                </div>
                <p class="text-gray-600 text-sm mt-1">
                    1 Burger Bánh Mì + 1 Khoai Tây Chiên (vừa) + 1 Lon Pepsi
                </p>
            </div>
            <div class="flex items-center justify-between mt-3">
                <p class="text-sm text-gray-500">Đã bán 50</p>
                <button
                    class="bg-red-400 text-white text-xs py-1 px-3 rounded-md uppercase hover:bg-red-600 transition"
                >
                    Thêm vào giỏ
                </button>
            </div>
        </div>
    </div>
</template>
