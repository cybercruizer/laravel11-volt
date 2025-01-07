<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('db_transaksi2425', function (Blueprint $table) {
            $table->integer('no');
            $table->dateTime('tanggal');
            $table->string('nis', 18);
            $table->string('nama', 100);
            $table->string('kelamin', 2);
            $table->string('jenjang', 5);
            $table->string('paralel', 50);
            $table->string('kategori', 30);
            $table->string('jenis', 2);
            $table->float('tahap');
            $table->string('jumlah', 15);
            $table->string('random', 20);
            $table->string('penerima', 100);
            $table->string('setor', 10);
            $table->string('id_setor', 50);
            $table->string('metode', 20);
            $table->text('catatan')->nullable();
            $table->dateTime('time');
            $table->string('ip', 30);
            $table->text('browser')->nullable();
            $table->string('id_tr', 50);
            $table->string('id', 50);
            $table->primary('no');
        });
    }
    /** * Reverse the migrations. * * @return void */ public function down()
    {
        Schema::dropIfExists('db_transaksi2425');
    }
};
