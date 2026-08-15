<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota_Keluarga extends Model
{
    // Mencegah Laravel otomatis mengubah nama relasi camelCase (kepalaKeluarga)
    // jadi snake_case (kepala_keluarga) saat di-serialize ke JSON — supaya
    // konsisten dengan nama relasi yang dipakai di frontend.
    public static $snakeAttributes = false;

    protected $table = 'anggota_keluarga';
    protected $primaryKey = 'nik';
    protected $fillable = [
        'no_kk',
        'hubungan_keluarga',
        'nik',
        'nama_anggota_keluarga',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'pendidikan_terakhir',
        'pekerjaan',
        'status_perkawinan'
    ];

    public function kepalaKeluarga()
    {
        return $this->belongsTo(Kepala_Keluarga::class, 'no_kk', 'no_kk');
    }
}
