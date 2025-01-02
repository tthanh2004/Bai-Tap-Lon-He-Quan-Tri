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
        Schema::create('chitiethoadon', function (Blueprint $table) {
            $table->char('idhoadon');
            $table->char('idsanpham');
            $table->integer('soluongmua');
            $table->decimal('giamgia', 5, 2);
            $table->decimal('thanhtien', 18, 2);
            $table->timestamps();

            $table->primary(['idhoadon', 'idsanpham']);

            $table->foreign('idhoadon')->references('mahoadon')->on('hoadon')->onDelete('cascade');
            $table->foreign('idsanpham')->references('masanpham')->on('sanpham')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chitiethoadon');
    }
};
