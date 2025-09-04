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
        Schema::table('product_thumbnails', function (Blueprint $table) {
            // Thêm foreign key constraint cho product_id
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            
            // Thêm index cho product_id để tăng hiệu suất truy vấn
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_thumbnails', function (Blueprint $table) {
            // Xóa foreign key constraint
            $table->dropForeign(['product_id']);
            
            // Xóa index
            $table->dropIndex(['product_id']);
        });
    }
};
