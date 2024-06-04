<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggalKirim extends Model
{
    use HasFactory;

    protected $fillable = ['pesanan_id', 'tgl_kirim'];
    protected $casts = [
        'tgl_kirim' => 'datetime'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}
