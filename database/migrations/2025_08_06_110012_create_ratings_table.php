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
        if (!Schema::hasTable('ratings')) {
            Schema::create('ratings', function (Blueprint $table) {
                $table->id();
                
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('status_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_variant_id')->constrained()->onDelete('cascade'); 
                $table->foreignId('order_id')->constrained()->onDelete('cascade');
                $table->foreignId('order_detail_id')->constrained()->onDelete('cascade');
                
                $table->tinyInteger('rating')->unsigned()->comment('Từ 1 đến 5 sao');
                $table->timestamps();

                $table->unique(['user_id', 'order_detail_id'], 'unique_rating_per_order_detail');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('ratings')) {
            Schema::dropIfExists('ratings');
        }
    }
};
