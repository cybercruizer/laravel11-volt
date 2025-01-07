<?php

namespace App\Models;

use App\Models\Siswa;
use App\Models\Tahunajaran;
use App\Models\Pembayaran2425;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tagihan extends Model
{
    use HasFactory;
    protected $connection='keuangan_db';
    protected $table = 'tb_nama_bayar';
    protected $primaryKey= 'id';
    public $incrementing=false;
    protected $keyType = 'string';
    protected $guarded = [];

    /**
     * Get all of the pembayarans for the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran2425::class, 'pem_id', 'id');
    }
    
}
