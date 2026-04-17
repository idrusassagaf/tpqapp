<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresAlquran extends Model
{
    use HasFactory;

    protected $fillable = ['santri_id', 'guru_id', 'juz', 'hal', 'progres'];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
