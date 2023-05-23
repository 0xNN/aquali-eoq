<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 10);
            $table->string('nama_barang', 50);
            $table->integer('kategori_id');
            $table->integer('harga_beli')->default(0);
            $table->integer('harga_jual')->default(0);
            $table->integer('stok')->default(0);
            $table->integer('safety_stok')->default(0);
            $table->integer('eoq')->default(0);
            $table->string('gambar', 100)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
