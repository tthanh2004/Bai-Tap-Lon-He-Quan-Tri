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
        Schema::create('hoadon', function (Blueprint $table) {
            $table->char('mahoadon');
            $table->char('idkhachhang');
            $table->char('idnhanvien');
            $table->dateTime('ngaylaphoadon');
            $table->boolean('sudungTTD')->default(true);
            $table->decimal('tongtien', 18, 2);
            $table->timestamps();

            $table->primary('mahoadon');

            $table->foreign('idkhachhang')->references('makhachhang')->on('khachhang')->onDelete('cascade');
            $table->foreign('idnhanvien')->references('manhanvien')->on('nhanvien')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoadon');
    }
};
