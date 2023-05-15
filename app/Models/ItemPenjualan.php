<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPenjualan extends Model
{
    use HasFactory;
    
    protected $table = 'item_penjualans';

    public $timestamps = true;

    protected $fillable = [
        'nota',
        'kode_barang',
        'quantity',
    ];
}
