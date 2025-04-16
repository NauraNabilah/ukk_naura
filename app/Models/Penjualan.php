<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan'; 
    public $timestamps = true;

    protected $fillable = [
        'tanggal', 
        'id_member', 
        'total_harga', 
        'uang_diberi', 
        'uang_kembali', 
        'petugas',
        'point_used',
        'point_earned'
    ];

    public function detailPenjualan()
    {
        return $this->hasMany(detailPenjualan::class, 'id_penjualan');
    }
    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }
}
