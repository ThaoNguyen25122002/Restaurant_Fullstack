<script setup></script>

<template>
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-blue-500 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Trang Nhân Viên Giao Hàng</h1>
                <button
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded"
                >
                    Đăng xuất
                </button>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto p-6">
            <!-- Thông tin cá nhân -->
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Thông tin cá nhân</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-600">Tên nhân viên</label>
                        <p class="bg-gray-100 p-2 rounded">Nguyễn Văn B</p>
                    </div>
                    <div>
                        <label class="text-gray-600">Email</label>
                        <p class="bg-gray-100 p-2 rounded">
                            nguyenvanb@gmail.com
                        </p>
                    </div>
                    <div>
                        <label class="text-gray-600">Số điện thoại</label>
                        <p class="bg-gray-100 p-2 rounded">0123 456 789</p>
                    </div>
                </div>
            </div>

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
                            <th class="p-2 text-left">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="p-2">#123456</td>
                            <td class="p-2">Nguyễn Văn A</td>
                            <td class="p-2">0123 456 789</td>
                            <td class="p-2">123 Đường ABC, TP.HCM</td>
                            <td class="p-2">
                                <select class="w-full bg-gray-100 p-2 rounded">
                                    <option>Chưa giao</option>
                                    <option>Đang giao</option>
                                    <option>Đã giao thành công</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-2">#654321</td>
                            <td class="p-2">Trần Văn C</td>
                            <td class="p-2">0987 654 321</td>
                            <td class="p-2">456 Đường XYZ, Hà Nội</td>
                            <td class="p-2">
                                <select class="w-full bg-gray-100 p-2 rounded">
                                    <option>Chưa giao</option>
                                    <option>Đang giao</option>
                                    <option>Đã giao thành công</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-200 text-gray-600 text-center p-4">
            © 2024 Công ty ABC
        </footer>
    </div>
</template>
