<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->nullable()->constrained('statuses')->after('id');
            $table->string('code', 50)->unique();
            $table->enum('type', ['percentage', 'fixed']);
            $table->decimal('value', 10, 2);
            $table->decimal('max_discount', 10, 2)->nullable();
            $table->decimal('min_order_value', 10, 2)->default(0);
            $table->integer('usage_limit')->default(1);
            $table->integer('used')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};

