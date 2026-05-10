<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $primaryKey = 'id_detail';
    protected $table = 'detail_penjualans';
    protected $fillable = ['id_penjualan', 'id_produk', 'jumlah', 'harga', 'subtotal'];
    public $timestamps = true;

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan', 'id_penjualan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
