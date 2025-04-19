<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;
    
    protected $table = 'pembelian_details'; // Menentukan nama tabel yang benar
    
    protected $fillable = [
        'pembelian_id',
        'id_produk',      // Sesuaikan dengan nama kolom di migration
        'quantity',
        'total_price'     // Sesuaikan dengan nama kolom di migration
    ];
    
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk'); // Sesuaikan foreign key
    }
}