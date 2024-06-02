<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipePaket extends Model
{
    use HasFactory;

    public function paket()
    {
        return $this->hasMany(Paket::class, "tipe_id");
    }
}
