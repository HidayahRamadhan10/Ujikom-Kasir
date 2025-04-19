<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'harga',
        'stok',
        'img'
    ];

    // Accessor untuk URL gambar
    public function getImageUrlAttribute()
    {
        if ($this->img) {
            return asset('storage/products/' . $this->img);
        }
        return asset('img/default-product.png'); // Gambar default jika tidak ada
    }

    // Accessor untuk format harga
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Scope untuk produk yang tersedia (stok > 0)
    public function scopeAvailable($query)
    {
        return $query->where('stok', '>', 0);
    }
    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }
}