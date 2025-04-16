<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;


    protected $table = 'produks';
    protected $fillable = [
         'gambar',
         'nama_produk',
         'harga',
         'stok',
    ];

    public function detailPenjualan()
    {
        return $this->hasMany(detailPenjualan::class, 'id_produk', 'id');
    }
}
