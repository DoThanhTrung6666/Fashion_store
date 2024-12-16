<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('product_variant_id');  // Thêm cột `product_variant_id`
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade'); // Khóa ngoại
        });
    }
    
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['product_variant_id']);  // Xóa khóa ngoại
            $table->dropColumn('product_variant_id');  // Xóa cột `product_variant_id`
        });
    }
    
};
