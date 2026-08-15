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
        Schema::create('kepala_keluarga', function (Blueprint $table) {
            $table->string('no_kk', 16)->primary();
            $table->string('nik', 16)->unique();
            $table->string('nama_kepala_keluarga');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu']);
            $table->enum('pendidikan_terakhir', ['Tidak/Belum Sekolah', 'Belum Tamat SD/Sederajat','Tamat SD/Sederajat','SLTP/Sederajat','SLTA/Sederajat','Diploma I/II','Diploma III','Diploma IV/Strata I','Strata II','Strata III',]);
            $table->string('pekerjaan');
            $table->enum('status_perkawinan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']);
            $table->string('alamat_lengkap');
            $table->integer('rt');
            $table->integer('rw');
            $table->unsignedBigInteger('banjar_id');
            $table->foreign('banjar_id')->references('id')->on('banjar');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('status_penduduk', ['Permanen', 'Non-permanen']);
            $table->string('alamat_asal')->nullable();
            $table->date('tanggal_mulai_tinggal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepala_keluarga');
    }
};
