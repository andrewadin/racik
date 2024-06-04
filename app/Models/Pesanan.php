<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $fillable = ['no_nota', 'konsumen_id', 'paket_id', 'waktu_id', 'jumlah', 'diskon', 'harga_tambahan', 'total', 'catatan'];


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
