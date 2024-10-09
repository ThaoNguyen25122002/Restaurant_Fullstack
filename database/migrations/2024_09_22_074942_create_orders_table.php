<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('staff_id')->nullable()->constrained('users')->onDelete('set null'); 
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_method',['vnpay','cod'])->default('cod');
            $table->enum('status', ['Chờ duyệt', 'Đã nhận đơn', 'Đang giao hàng', 'Đã giao hàng', 'Đã hủy', 'Đã đánh giá'])->default('Chờ duyệt');
            $table->string('delivery_address');
            $table->string('note')->nullable();
            $table->timestamp('delivery_start_time')->nullable()->after('note');
            $table->timestamp('delivery_end_time')->nullable()->after('delivery_start_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
