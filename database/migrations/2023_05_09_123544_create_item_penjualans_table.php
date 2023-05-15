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
        Schema::create('item_penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('nota');
            $table->string('kode_barang');
            $table->integer('quantity')->unsigned();
            $table->timestamps();

            $table->foreign('kode_barang')->references('kode')->on('barangs');
            $table->foreign('nota')->references('id_nota')->on('penjualans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_penjualans');
    }
};
