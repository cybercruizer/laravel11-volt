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
        Schema::create('woroworos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('judul');
            $table->text('konten');
            $table->enum('kategori', ['kurikulum','kesiswaan', 'keuangan','umum','walikelas'])->nullable()->default('umum');
            $table->enum('status',['aktif','nonaktif']);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('woroworos');
    }
};
