<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $primaryKey = 'id_produk';
    protected $fillable = ['nama_produk', 'tipe_produk', 'id_kategori', 'id_brand', 'harga', 'terjual'];
    public $timestamps = true;

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand', 'id_brand');
    }

    public function stok()
    {
        return $this->hasOne(Stok::class, 'id_produk', 'id_produk');
    }

    public function details()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_produk', 'id_produk');
    }
}
