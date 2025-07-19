<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('status_logs', function (Blueprint $table) {
            $table->id();

            // ID trạng thái mới
            $table->foreignId('status_id')->nullable()->constrained('statuses')->nullOnDelete();

            // Ai thay đổi (user)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Ghi chú nếu có
            $table->text('note')->nullable();

            // Morph liên kết đến orders hoặc các bảng khác
            $table->unsignedBigInteger('loggable_id');
            $table->string('loggable_type');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_logs');
    }
};
