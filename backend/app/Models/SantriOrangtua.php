<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SantriOrangtua extends Model
{
    use HasFactory;

    protected $table = 'santri_orangtua';

    protected $fillable = [
    'nama_ayah','nama_ibu','status_orangtua','pekerjaan_ayah','pekerjaan_ibu','no_kontak','alamat'
];

    // relasi ke Santri
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
