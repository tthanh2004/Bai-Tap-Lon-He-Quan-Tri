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
        Schema::create('thetichdiem', function (Blueprint $table) {
            $table->char('mathetichdiem');
            $table->integer('diemtichluy');
            $table->char('idkhachhang')->unique();
            $table->foreign('idkhachhang')->references('makhachhang')->on('khachhang')->onDelete('cascade');
            $table->timestamps();

            $table->primary('mathetichdiem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thetichdiem');
    }
};
