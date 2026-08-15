<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';

    protected $fillable = [
        'nama_fasilitas',
        'jenis_fasilitas',
        'lokasi_banjar_id',
        'kondisi',
        'keterangan',
        'latitude',
        'longitude',
        'foto_url',
    ];

    public function banjar()
    {
        return $this->belongsTo(Banjar::class, 'lokasi_banjar_id');
    }
}
