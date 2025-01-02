<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Hãng
    public function up(): void
    {
        Schema::create('hang', function (Blueprint $table) {
            $table->char('mahang');
            $table->string('tenhang');
            $table->string('diachi');
            $table->timestamps();

            $table->primary('mahang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hang');
    }
};
