<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detailPenjualan extends Model
{

    protected $table = 'detailPenjualans';

    protected $fillable = ['id_penjualan', 'id_produk', 'jumlah', 'harga', 'sub_total'];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }
}
