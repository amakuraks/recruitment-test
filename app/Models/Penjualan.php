<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penjualan extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'penjualans';

    public $timestamps = true;

    protected $fillable = [
        'id_nota',
        'tanggal_transaksi',
        'kode_pelanggan',
        'subtotal',
    ];

    protected $hidden = ['id'];

    /**
     * Get the pelanggan that owns the Penjualan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'kode_pelanggan', 'id_pelanggan');
    }

    /**
     * The barang that belong to the Penjualan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function barang(): BelongsToMany
    {
        return $this->belongsToMany(Barang::class, 'item_penjualans', 'nota', 'kode_barang', 'id_nota', 'kode')->withPivot('quantity')->withTimestamps();
    }
}
