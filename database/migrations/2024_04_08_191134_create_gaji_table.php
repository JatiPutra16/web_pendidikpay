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
        Schema::create('gaji', function (Blueprint $table) {
            $table->increments('idgaji');
            $table->integer('idguru');
            $table->integer('idabsen')->nullable();
            $table->string('nik')->unique();
            $table->date('tgl_gaji');
            $table->string('total_gaji');
            $table->string('tabungan');
            $table->string('gaji_bersih');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
