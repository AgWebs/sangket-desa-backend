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
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_fasilitas');
            $table->enum('jenis_fasilitas', ['pendidikan', 'kesehatan', 'ibadah', 'olahraga', 'umum']);
            $table->unsignedBigInteger('lokasi_banjar_id');
            $table->foreign('lokasi_banjar_id')->references('id')->on('banjar');
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};
