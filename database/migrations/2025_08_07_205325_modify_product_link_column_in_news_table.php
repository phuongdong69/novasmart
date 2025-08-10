<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('news')) return;

        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasColumn('news', 'product_link')) {
                // Nếu chưa có thì thêm mới
                $table->text('product_link')->nullable();
            } else {
                // Nếu đã có thì mới đổi kiểu (cần doctrine/dbal nếu dùng change())
                $table->text('product_link')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('news')) return;

        Schema::table('news', function (Blueprint $table) {
            if (Schema::hasColumn('news', 'product_link')) {
                $table->dropColumn('product_link');
            }
        });
    }
};
