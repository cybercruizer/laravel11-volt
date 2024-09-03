<?php

namespace App\Models;

use App\Models\User;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelanggaran extends Model
{
    use HasFactory;
    protected $table = 'pelanggarans';
    protected $connection ='mysql';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class,'siswa_id');
    }
    /**
     * Get the jenispelanggaran that owns the Pelanggaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenisPelanggaran(): BelongsTo
    {
        return $this->belongsTo(JenisPelanggaran::class,'jenis_pelanggaran_id');
    }
    /**
     * Get the user that owns the Pelanggaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
