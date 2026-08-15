<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bantuan extends Model
{
    protected $table = 'bantuan';
    
    protected $primaryKey = 'kode_bantuan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_bantuan',
        'nama_bantuan',
        'keterangan',
        'sumber_dana',
        'status',
    ];

    public function bantuanPenduduk()
    {
        return $this->hasMany(Bantuan_Penduduk::class, 'bantuan_kode', 'kode_bantuan');
    }
}
