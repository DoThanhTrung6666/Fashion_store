<?php

use App\Models\Shipper;
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
        Schema::table('orders', function (Blueprint $table) {
            //
            // $table->foreignIdFor(Shipper::class)->constrained()->nullable();
            $table->unsignedBigInteger('shipper_id')->nullable();  // Thêm cột shipper_id
            $table->foreign('shipper_id')->references('id')->on('shippers')->onDelete('set null');  // Thêm khóa ngoại
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->dropForeign(['shipper_id']);
            $table->dropColumn('shipper_id');
        });
    }
};
