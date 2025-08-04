<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // mã giảm giá duy nhất
        $table->string('description')->nullable(); // mô tả
        $table->enum('discount_type', ['percent', 'fixed']); // loại giảm giá
        $table->decimal('discount_value', 10, 2); // giá trị giảm
        $table->integer('quantity')->default(0); // số lượng còn lại
        $table->dateTime('expired_at'); // ngày hết hạn
        $table->foreignId('status_id')->constrained()->onDelete('cascade'); // liên kết bảng statuses
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};

