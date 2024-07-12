<?php

namespace App\Models;

use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelanggaran extends Model
{
    use HasFactory;

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    /**
     * Get the jenispelanggaran that owns the Pelanggaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenisPelanggaran(): BelongsTo
    {
        return $this->belongsTo(JenisPelanggaran::class, 'id', 'jenis_pelanggaran_id');
    }
}
