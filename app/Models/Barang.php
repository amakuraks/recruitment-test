<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Barang extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'barangs';

    public $timestamps = true;

    protected $fillable = [
        'nama',
        'kode',
        'kategori',
        'harga',
    ];

    protected $hidden = ['id'];

    /**
     * The penjualan that belong to the Barang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function penjualan(): BelongsToMany
    {
        return $this->belongsToMany(Penjualan::class, 'item_penjualans', 'kode_barang', 'nota', 'kode', 'id_nota')->withPivot('quantity');
    }
}
