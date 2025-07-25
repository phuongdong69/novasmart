<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_cancellations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('cancelled_by')->nullable(); // user huỷ
            $table->text('reason')->nullable(); // lý do huỷ
            $table->timestamp('cancelled_at')->nullable(); // thời gian huỷ

            $table->timestamps();

            // Ràng buộc khóa ngoại
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('cancelled_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_cancellations');
    }
};
