<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    public function tipe()
    {
        return $this->belongsTo(TipePaket::class, 'tipe_id');
    }
}
