<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $primaryKey = 'id_brand';
    protected $fillable = ['nama_brand'];
    public $timestamps = true;

    public function produks()
    {
        return $this->hasMany(Produk::class, 'id_brand', 'id_brand');
    }
}
