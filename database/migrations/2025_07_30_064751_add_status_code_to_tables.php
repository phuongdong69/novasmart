<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Thêm status_code cho bảng users
        Schema::table('users', function (Blueprint $table) {
            $table->string('status_code')->nullable()->after('status_id');
        });

        // Thêm status_code cho bảng products
        Schema::table('products', function (Blueprint $table) {
            $table->string('status_code')->nullable()->after('status_id');
        });

        // Thêm status_code cho bảng vouchers
        Schema::table('vouchers', function (Blueprint $table) {
            $table->string('status_code')->nullable()->after('status_id');
        });

        // Cập nhật dữ liệu cho users
        DB::table('users')->update(['status_code' => 'active']);

        // Cập nhật dữ liệu cho products
        DB::table('products')->update(['status_code' => 'published']);

        // Cập nhật dữ liệu cho vouchers
        DB::table('vouchers')->update(['status_code' => 'active']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status_code');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('status_code');
        });

        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn('status_code');
        });
    }
};
