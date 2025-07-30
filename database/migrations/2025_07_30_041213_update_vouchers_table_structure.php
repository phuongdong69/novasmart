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
        Schema::table('vouchers', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['discount_type', 'discount_value', 'expiry_date', 'quantity']);
            
            // Add new columns
            $table->enum('type', ['percentage', 'fixed'])->after('code');
            $table->decimal('value', 10, 2)->after('type');
            $table->decimal('max_discount', 10, 2)->nullable()->after('value');
            $table->decimal('min_order_value', 10, 2)->default(0)->after('max_discount');
            $table->integer('usage_limit')->default(1)->after('min_order_value');
            $table->integer('used')->default(0)->after('usage_limit');
            $table->date('start_date')->after('used');
            $table->date('end_date')->after('start_date');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->after('end_date');
            $table->boolean('is_public')->default(true)->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            // Drop new columns
            $table->dropForeign(['user_id']);
            $table->dropColumn(['type', 'value', 'max_discount', 'min_order_value', 'usage_limit', 'used', 'start_date', 'end_date', 'user_id', 'is_public']);
            
            // Add back old columns
            $table->enum('discount_type', ['percentage', 'fixed'])->after('code');
            $table->decimal('discount_value', 10, 2)->after('discount_type');
            $table->date('expiry_date')->after('discount_value');
            $table->integer('quantity')->after('expiry_date');
        });
    }
};
