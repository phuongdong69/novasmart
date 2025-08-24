<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            // Đơn tối thiểu để áp dụng (vd 1.000.000đ)
            $table->unsignedBigInteger('min_order_total')->default(0)->after('discount_value');
            // Trần giảm tối đa (vd 300.000đ); cho phép null = không giới hạn
            $table->unsignedBigInteger('max_discount')->nullable()->after('min_order_total');
        });
    }

    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn(['min_order_total', 'max_discount']);
        });
    }
};
