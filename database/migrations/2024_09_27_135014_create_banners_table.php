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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();  // Tiêu đề banner, cho phép rỗng
            $table->text('description')->nullable();  // Mô tả banner, có thể không cần
            $table->string('image_path');  // Đường dẫn hình ảnh
            $table->string('link')->nullable();  // Link banner sẽ điều hướng tới
            $table->integer('position')->default(0);  // Vị trí hiển thị
            $table->dateTime('start_date')->nullable();  // Ngày bắt đầu hiển thị
            $table->dateTime('end_date')->nullable();  // Ngày kết thúc hiển thị
            $table->boolean('is_active')->default(true);  // Trạng thái hoạt động
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
