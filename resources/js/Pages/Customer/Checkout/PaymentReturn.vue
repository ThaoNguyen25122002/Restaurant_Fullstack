<script setup>
const props = defineProps({
    vnpData: Object,
});
const formatCurrency = (value) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
};
function formatVNPayDate(vnpDate) {
    const year = vnpDate.substring(0, 4);
    const month = vnpDate.substring(4, 6);
    const day = vnpDate.substring(6, 8);
    const hour = vnpDate.substring(8, 10);
    const minute = vnpDate.substring(10, 12);
    const second = vnpDate.substring(12, 14);

    return `${day}/${month}/${year} ${hour}:${minute}:${second}`;
}
console.log(props.vnpData);
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg w-full">
            <div class="flex items-center justify-center mb-6">
                <div class="bg-green-100 p-4 rounded-full">
                    <svg
                        class="w-12 h-12 text-green-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2l4 -4m0 0v6a2 2 0 002 2h2m-6 0a2 2 0 01-2-2v-6m6 0a2 2 0 012-2h2a2 2 0 012 2v6a2 2 0 01-2 2h-2"
                        />
                    </svg>
                </div>
            </div>
            <h2 class="text-2xl font-semibold text-center text-gray-800">
                Thanh toán thành công!
            </h2>
            <p class="text-center text-gray-600 mt-2">
                Cảm ơn bạn đã mua hàng. Thông tin chi tiết về thanh toán của bạn
                như sau:
            </p>

            <div class="mt-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-700 font-medium">Mã đơn hàng:</span>
                    <span class="text-gray-900 font-semibold">{{
                        vnpData.vnp_TxnRef
                    }}</span>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-700 font-medium">Mã giao dịch:</span>
                    <span class="text-gray-900 font-semibold">{{
                        vnpData.vnp_TransactionNo
                    }}</span>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-700 font-medium"
                        >Số tiền thanh toán:</span
                    >
                    <span class="text-gray-900 font-semibold">{{
                        formatCurrency(vnpData.vnp_Amount / 100)
                    }}</span>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-700 font-medium"
                        >Ngân hàng thanh toán:</span
                    >
                    <span class="text-gray-900 font-semibold"
                        >Ngân hàng {{ vnpData.vnp_BankCode }}</span
                    >
                </div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-700 font-medium"
                        >Ngày giao dịch:</span
                    >
                    <span class="text-gray-900 font-semibold">{{
                        formatVNPayDate(vnpData.vnp_PayDate)
                    }}</span>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-700 font-medium">Ghi chú:</span>
                    <span class="text-gray-900 font-semibold">{{
                        vnpData.note ? vnpData.note : "Không có ghi chú"
                    }}</span>
                </div>
            </div>

            <div class="mt-8 flex justify-center">
                <Link
                    :href="route('home')"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg shadow"
                >
                    Quay lại trang chủ
                </Link>
            </div>
        </div>
    </div>
</template>
