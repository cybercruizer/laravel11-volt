<?php

namespace App\Models;

use App\Models\Tagihan;
use App\Models\Presensi;
use App\Models\Pelanggaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'spa_students';
    protected $guarded=[];
    protected $primaryKey='student_id';

    public function scopeAktif($query) {
        return $query->where([['student_status', 'A'],['is_deleted', 0]]);
    }
    /**
     * Get the kelas that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'class_id');
    }
    /**
     * Get all of the presensis for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function presensis(): HasMany
    {
        return $this->hasMany(Presensi::class,'student_id');
    }
    /**
     * Get all of the pelanggarans for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pelanggarans(): HasMany
    {
        return $this->hasMany(Pelanggaran::class, 'siswa_id');
    }
    /**
     * Get all of the tagihan for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagihans(): HasMany
    {
        return $this->hasMany(Tagihan::class, 'siswa_id');
    }
}
