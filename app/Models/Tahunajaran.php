<?php

namespace App\Models;

use App\Models\Kelas;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Pembayaran2425;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tahunajaran extends Model
{
    use HasFactory;
    protected $table = 'spa_classyears';
    protected $guarded=[];
    protected $primaryKey='year_id';

    /**
     * Get all of the kelases for the Tahunajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scopeAktif($query) {
        return $query->where([['is_active', 1],['is_deleted', 0]]);
    }
    public function kelases(): HasMany
    {
        return $this->hasMany(Kelas::class, 'year_id', 'year_id');
    }
    /**
     * Get all of the tagihans for the Tahunajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagihans(): HasMany
    {
        return $this->hasMany(Tagihan::class, 'tp','year_code');
    }
    /**
     * Get all of the pembayarans for the Tahunajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran2425::class, 'ta_id');
    }
}
