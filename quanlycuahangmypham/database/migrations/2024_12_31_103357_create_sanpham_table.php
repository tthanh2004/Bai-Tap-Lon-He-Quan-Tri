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
        Schema::create('sanpham', function (Blueprint $table) {
            $table->char('masanpham');
            $table->char('idhang');
            $table->string('tensanpham');
            $table->string('donvitinh');
            $table->decimal('dongia', 18, 2);
            $table->integer('soluongton');
            $table->string('anhsanpham');
            $table->foreign('idhang')->references('mahang')->on('hang')->onDelete('cascade');
            $table->timestamps();

            $table->primary('masanpham');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanpham');
    }
};
