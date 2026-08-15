<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banjar extends Model
{
    protected $table = 'banjar';

    protected $fillable = [
        'nama_banjar',
    ];

    public function fasilitas()
    {
        return $this->hasMany(Fasilitas::class, 'lokasi_banjar_id');
    }
}
