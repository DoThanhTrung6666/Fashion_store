<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tiêu đề banner, cho phép rỗng
            $table->text('description')->nullable(); // Mô tả banner, có thể không cần
            $table->string('image_path'); // Đường dẫn hình ảnh
            $table->boolean('is_active')->default(true);  // Trạng thái hoạt động
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('banners');
    }
};

