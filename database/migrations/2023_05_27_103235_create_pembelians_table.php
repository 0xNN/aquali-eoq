<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembelian');
            $table->integer('supplier_id');
            $table->integer('status_permintaan')->default(0)->comment('0: permintaan, 1: disetujui, 2: ditolak');
            $table->integer('status_pembelian')->default(0)->comment('0: belum diterima, 1: diterima');
            $table->date('tanggal_permintaan');
            $table->date('tanggal_pembelian')->nullable();
            $table->integer('user_id_permintaan');
            $table->integer('user_id_pembelian')->nullable();
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
        Schema::dropIfExists('pembelians');
    }
}
