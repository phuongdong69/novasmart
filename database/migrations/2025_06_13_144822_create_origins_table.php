<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('origins', function (Blueprint $table) {
        $table->id();
        $table->foreignId('status_id')->nullable()->constrained('statuses')->after('id');
        $table->string('country'); 
        $table->timestamps(); 
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('origins');
    }
};
