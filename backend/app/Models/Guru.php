<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nig',
        'jenis_kelamin',
        'mapel',
        'foto',
        'tempat_lahir',
        'tgl_lahir',
        'no_kontak',
        'pendidikan',
        'alamat',
        'kehadiran',      // tambahkan
        'status_guru',    // tambahkan
    ];

    // ✅ TAMBAHKAN DI SINI
    public function santris()
    {
        return $this->hasMany(\App\Models\Santri::class, 'guru_id');
    }
}
