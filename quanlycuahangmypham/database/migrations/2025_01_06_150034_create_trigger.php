<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER trg_AutoCreateTheTichDiem
            AFTER INSERT ON KHACHHANG
            FOR EACH ROW
            BEGIN
                INSERT INTO THETICHDIEM (mathetichdiem, diemtichluy, idkhachhang)
                VALUES (CONCAT('TD', NEW.makhachhang), 0, NEW.makhachhang);
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS trg_AutoCreateTheTichDiem");
    }
};
