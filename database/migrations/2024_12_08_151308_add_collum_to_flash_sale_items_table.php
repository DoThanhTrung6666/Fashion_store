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
        Schema::table('flash_sale_items', function (Blueprint $table) {
            //số lượng sản phẩm tối đa 10
            $table->integer('flash_sale_quantity');
            // số lượng đã bán
            $table->integer('sold_quanity')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flash_sale_items', function (Blueprint $table) {
            //
        });
    }
};
