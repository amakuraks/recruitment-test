<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'pelanggans';

    public $timestamps = true;

    protected $fillable = [
        'id_pelanggan',
        'nama',
        'domisili',
        'jenis_kelamin',
    ];

    protected $hidden = ['id'];

    /**
     * Get all of the penjualan for the Pelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penjualan(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'kode_pelanggan', 'id_pelanggan');
    }
}
