<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresIqra extends Model
{
    use HasFactory;

    protected $fillable = ['santri_id', 'iqra', 'hal', 'status', 'ulang_lanjut'];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
