<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'pembelian_id',
        'metode_pembayaran',
        'jumlah_bayar',
        'kembalian',
        'tanggal_bayar'
    ];
    
    protected $dates = [
        'tanggal_bayar'
    ];
    
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }
}