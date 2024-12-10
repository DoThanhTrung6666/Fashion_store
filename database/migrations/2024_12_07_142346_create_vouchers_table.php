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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id(); // ID chính của bảng
            $table->string('name'); // Tên voucher
            $table->unsignedTinyInteger('discount_percentage'); // Giảm giá %
            $table->unsignedBigInteger('max_discount'); // Giá giảm tối đa
            $table->unsignedBigInteger('min_order_value'); // Đơn tối thiểu
            $table->date('start_date'); // Ngày bắt đầu
            $table->date('end_date'); // Ngày kết thúc
            $table->string('status')->default('active'); // Trạng thái (mặc định là 'active')
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
