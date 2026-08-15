<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bantuan_Penduduk extends Model
{
    protected $table = 'bantuan_penduduk';
    protected $fillable = [
        'penduduk_no_kk',
        'bantuan_kode',
        'tanggal_menerima',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Kepala_Keluarga::class, 'penduduk_no_kk', 'no_kk');
    }

    public function bantuan()
    {
        return $this->belongsTo(Bantuan::class, 'bantuan_kode', 'kode_bantuan');
    }
}
