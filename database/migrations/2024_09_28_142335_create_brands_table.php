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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên thương hiệu
            $table->string('slug')->unique(); // Slug để tạo URL thân thiện, phải duy nhất
            $table->text('description')->nullable(); // Mô tả thương hiệu, cho phép giá trị null
            $table->string('logo')->nullable(); // Đường dẫn logo thương hiệu, cho phép null
            $table->tinyInteger('status')->default(1); // Trạng thái thương hiệu, 1: kích hoạt, 0: không kích hoạt
            $table->string('website_url')->nullable(); // Đường dẫn website thương hiệu, cho phép null
            $table->string('country')->nullable(); // Quốc gia của thương hiệu, cho phép null
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
