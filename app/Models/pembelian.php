<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'customer_name',
        'invoice_number',
        'grand_total',
        'tanggal',
        'dibuat_oleh'
    ];

    public function details()
    {
        return $this->hasMany(DetailPembelian::class, 'pembelian_id');
    }
    // Tambahkan relasi di model Pembelian.php
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
    
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'pembelian_details')
                    ->withPivot('quantity', 'total_price');
    }    
}