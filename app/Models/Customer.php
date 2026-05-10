<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'id_customer';
    protected $fillable = ['nama', 'no_hp', 'alamat'];
    public $timestamps = true;

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'id_customer', 'id_customer');
    }
}
