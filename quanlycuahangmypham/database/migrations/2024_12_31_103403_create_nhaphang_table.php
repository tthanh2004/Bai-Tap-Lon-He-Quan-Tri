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
        Schema::create('nhaphang', function (Blueprint $table) {
            $table->char('manhaphang');
            $table->char('idsanpham');
            $table->integer('soluongnhap');
            $table->decimal('gianhap', 18, 2);
            $table->dateTime('ngaynhap');
            $table->timestamps();

            $table->primary('manhaphang');

            $table->foreign('idsanpham')->references('masanpham')->on('sanpham')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhaphang');
    }
};
