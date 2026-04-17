<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    protected $fillable = [
        'nis',
        'nama',
        'jk',
        'tgl_lahir',
        'usia',
        'kelas',
        'status_santri',
        'foto',
        'orangtua_id',
        'guru_id',
    ];

    // Relasi ke orangtua

    public function orangtua()
    {
        return $this->hasOne(\App\Models\Orangtua::class, 'santri_id');
    }


    // Relasi ke guru
    public function guru()
    {
        return $this->belongsTo(\App\Models\Guru::class);
    }

    // Relasi progres Al Quran (WAJIB untuk filter Lanjut/Ulang)

    public function progresAlquran()
    {
        return $this->hasOne(\App\Models\ProgresAlquran::class);
    }

    // Relasi progres Iqra
    public function progresIqra()
    {
        return $this->hasOne(\App\Models\ProgresIqra::class);
    }
}
