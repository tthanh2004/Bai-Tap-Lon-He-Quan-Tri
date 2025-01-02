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
        Schema::create('nhanvien', function (Blueprint $table) {
            $table->char('manhanvien');
            $table->string('hoten');
            $table->enum('gioitinh', ['Nam', 'Nữ', 'Khác'])->default('Khác');
            $table->dateTime('ngaysinh');
            $table->string('diachi');
            $table->string('sodienthoai')->unique;
            $table->timestamps();

            $table->primary('manhanvien');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhanvien');
    }
};
