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
        Schema::create('jenis_pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->string('deskripsi', 255);
            $table->integer('poin');
            $table->timestamps();
        });

        Schema::create('pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_ajaran_id');
            $table->foreignId('user_id')->constrained();
            $table->integer('siswa_id');
            $table->date('tgl_pelanggaran');
            $table->foreignId('jenis_pelanggaran_id')->references('id')->on('jenis_pelanggarans')->onDelete('cascade');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggarans');
        Schema::dropIfExists('jenis_pelanggarans');
    }
};
