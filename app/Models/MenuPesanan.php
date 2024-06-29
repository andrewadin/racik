<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPesanan extends Model
{
    use HasFactory;
    protected $fillable = ['pesanan_id', 'paket_id', 'harga', 'jumlah'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }
}
