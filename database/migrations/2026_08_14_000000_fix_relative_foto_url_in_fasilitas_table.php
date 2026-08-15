<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\Fasilitas;

/**
 * Perbaikan data: foto_url yang tersimpan SEBELUM perbaikan APP_URL/url()
 * di FasilitasController masih berupa path relatif (mis. "/storage/fasilitas/
 * xxx.jpg"), yang membuat gambar 404 karena di-resolve browser ke origin
 * Next.js, bukan Laravel. Migrasi ini menambahkan origin backend (APP_URL) di
 * depan foto_url yang masih relatif, supaya data lama ikut kepakai tanpa
 * perlu upload ulang manual.
 */
return new class extends Migration
{
    public function up(): void
    {
        Fasilitas::where('foto_url', 'like', '/storage/%')->each(function ($fasilitas) {
            $fasilitas->foto_url = 'http://localhost' . $fasilitas->foto_url;
            $fasilitas->save();
        });
    }

    public function down(): void
    {
        // Data-fix satu arah, tidak perlu di-reverse.
    }
};
