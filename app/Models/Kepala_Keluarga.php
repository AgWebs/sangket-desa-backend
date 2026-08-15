<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Kepala_Keluarga extends Model
{
    // Mencegah Laravel otomatis mengubah nama relasi camelCase (anggotaKeluarga)
    // jadi snake_case (anggota_keluarga) saat di-serialize ke JSON.
    public static $snakeAttributes = false;

    protected $table = 'kepala_keluarga';
    protected $primaryKey = 'no_kk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_kk',
        'nik',
        'nama_kepala_keluarga',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'pendidikan_terakhir',
        'pekerjaan',
        'status_perkawinan',
        'alamat_lengkap',
        'rt',
        'rw',
        'banjar_id',
        'latitude',
        'longitude',
        'status_penduduk',
        'alamat_asal',
        'tanggal_mulai_tinggal'
    ];

    public function anggotaKeluarga()
    {
        return $this->hasMany(Anggota_Keluarga::class, 'no_kk', 'no_kk');
    }

    public function banjar()
    {
        return $this->belongsTo(Banjar::class, 'banjar_id', 'id');
    }

    public function bantuan()
    {
        return $this->hasMany(Bantuan_Penduduk::class, 'penduduk_no_kk', 'no_kk');
    }
}
