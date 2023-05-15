<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('id_nota', 255)->unique();
            $table->date('tanggal_transaksi');
            $table->string('kode_pelanggan');
            $table->decimal('subtotal', 9, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kode_pelanggan')->references('id_pelanggan')->on('pelanggans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
