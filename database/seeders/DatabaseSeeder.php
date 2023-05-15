<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\LogActivity;

use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\ItemPenjualan;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'      => 'Ezra',
            'email'     => 'eadriadi@gmail.com',
            'password'  => Hash::make('100mkonbini'),
            'is_active' => true,
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);

        Barang::insert([[
                "kode"      => "BRG_1",
                "nama"      => "Pen",
                "kategori"  => "ATK",
                "harga"     => "15000",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "kode"      => "BRG_2",
                "nama"      => "Pensil",
                "kategori"  => "ATK",
                "harga"     => "10000",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "kode"      => "BRG_3",
                "nama"      => "Payung",
                "kategori"  => "RT",
                "harga"     => "70000",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "kode"      => "BRG_4",
                "nama"      => "Panci",
                "kategori"  => "Masak",
                "harga"     => "110000",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "kode"      => "BRG_5",
                "nama"      => "Sapu",
                "kategori"  => "RT",
                "harga"     => "40000",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "kode"      => "BRG_6",
                "nama"      => "Kipas",
                "kategori"  => "Elektronik",
                "harga"     => "200000",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "kode"      => "BRG_7",
                "nama"      => "Kuali",
                "kategori"  => "Masak",
                "harga"     => "120000",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "kode"      => "BRG_8",
                "nama"      => "Sikat",
                "kategori"  => "RT",
                "harga"     => "30000",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "kode"      => "BRG_9",
                "nama"      => "Gelas",
                "kategori"  => "RT",
                "harga"     => "25000",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "kode"      => "BRG_10",
                "nama"      => "Piring",
                "kategori"  => "RT",
                "harga"     => "35000",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],
        ]);

        Pelanggan::insert([[
                "id_pelanggan"  => "PELANGGAN_1",
                "nama"          => "Andi",
                "domisili"      => "JAK-UT",
                "jenis_kelamin" => "PRIA",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "id_pelanggan"  => "PELANGGAN_2",
                "nama"          => "Budi",
                "domisili"      => "JAK-BAR",
                "jenis_kelamin" => "PRIA",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "id_pelanggan"  => "PELANGGAN_3",
                "nama"          => "Johan",
                "domisili"      => "JAK-SEL",
                "jenis_kelamin" => "PRIA",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "id_pelanggan"  => "PELANGGAN_4",
                "nama"          => "Sintha",
                "domisili"      => "JAK-TIM",
                "jenis_kelamin" => "WANITA",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "id_pelanggan"  => "PELANGGAN_5",
                "nama"          => "Anto",
                "domisili"      => "JAK-UT",
                "jenis_kelamin" => "PRIA",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "id_pelanggan"  => "PELANGGAN_6",
                "nama"          => "Bujang",
                "domisili"      => "JAK-BAR",
                "jenis_kelamin" => "PRIA",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "id_pelanggan"  => "PELANGGAN_7",
                "nama"          => "Jowan",
                "domisili"      => "JAK-SEL",
                "jenis_kelamin" => "PRIA",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "id_pelanggan"  => "PELANGGAN_8",
                "nama"          => "Sintia",
                "domisili"      => "JAK-TIM",
                "jenis_kelamin" => "WANITA",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "id_pelanggan"  => "PELANGGAN_9",
                "nama"          => "Butet",
                "domisili"      => "JAK-BAR",
                "jenis_kelamin" => "WANITA",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                "id_pelanggan"  => "PELANGGAN_10",
                "nama"          => "Jonny",
                "domisili"      => "JAK-SEL",
                "jenis_kelamin" => "WANITA",
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],
        ]);

        Penjualan::insert([[
                "id_nota"           => "NOTA_1",
                "tanggal_transaksi" => Carbon::create("2018","01","01"),
                "kode_pelanggan"    => "PELANGGAN_1",
                'subtotal'          => 50000,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],
            [
                "id_nota"           => "NOTA_2",
                "tanggal_transaksi" => Carbon::create("2018","01","01"),
                "kode_pelanggan"    => "PELANGGAN_2",
                'subtotal'          => 200000,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],
        ]);

        ItemPenjualan::insert([[
                'nota'              => "NOTA_1",
                'kode_barang'       => "BRG_1",
                'quantity'          => 2,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],[
                'nota'              => "NOTA_1",
                'kode_barang'       => "BRG_2",
                'quantity'          => 2,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],
            [
                'nota'              => "NOTA_2",
                'kode_barang'       => "BRG_6",
                'quantity'          => 1,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
            ],
        ]);

        LogActivity::create([
            "result"        => true,
            "message"       => "Log init seeder",
            "type"          => "Seed",
            "controller"    => "LogActivitySeeder",
            "function"      => "run",
        ]);
    }
}
