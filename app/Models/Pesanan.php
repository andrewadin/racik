<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'konsumen_id');
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }

    public function tgl_kirim()
    {
        return $this->hasMany(TanggalKirim::class, 'pesanan_id');
    }

    public function waktu()
    {
        return $this->belongsTo(WaktuKirim::class, 'waktu_id');
    }
}
