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
        Schema::table('orders', function (Blueprint $table) {
            // Thêm cột product_id vào bảng orders
            $table->unsignedBigInteger('product_id')->nullable()->after('id');
            
            // Thêm khóa ngoại để liên kết với bảng products
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Xóa khóa ngoại và cột product_id nếu rollback migration
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }
};