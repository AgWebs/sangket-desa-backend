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
        Schema::create('bantuan_penduduk', function (Blueprint $table) {
            $table->id();
            $table->string('penduduk_no_kk');
            $table->foreign('penduduk_no_kk')->references('no_kk')->on('kepala_keluarga')->onDelete('cascade');
            $table->string('bantuan_kode');
            $table->foreign('bantuan_kode')->references('kode_bantuan')->on('bantuan')->onDelete('cascade');
            $table->date('tanggal_menerima')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bantuan_penduduk');
    }
};
