<?php

namespace App\Models;

use App\Models\Penjualan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'poin', 'tanggal_gabung'];


    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'id_member');
    }

    public function isFirstTransaction()
    {
    return $this->penjualans()->where('member_id', $this->id)->count() == 1;
    }

}
