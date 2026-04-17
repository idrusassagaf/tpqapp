<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orangtua extends Model
{
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'nama_ayah',
        'nama_ibu',
        'status_orangtua',
        'alamat',
        'no_kontak',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
    ];

   public function santri()
{
    return $this->belongsTo(\App\Models\Santri::class);
}


}
