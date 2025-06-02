<?php

namespace App\Models;

use App\Models\Tagihan;
use App\Models\Presensi;
use App\Models\Pelanggaran;
use App\Models\TagihanSiswa;
use App\Models\Pembayaran2425;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'spa_students';
    protected $fillable = [
        'student_name',
        'student_number',
        'class_id',
        'year_id',
        'student_category',
        'student_pob',
        'student_dob',
        'student_gender',
        'student_nik',
        'student_nkk',
        'student_school_name',
        'student_province',
        'student_city',
        'student_district',
        'student_village',
        'student_address',
        'student_phone',
        'student_year_in',
        'student_year_out',
        'student_status',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
        'ortu_phone',
    ];
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
    /**
     * Get the tagihan associated with the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tagihan(): HasOne
    {
        return $this->hasOne(TagihanSiswa::class, 'nis', 'student_number');
    }
    public function pembayarans () : HasMany
    {
        return $this->hasMany(Pembayaran2425::class,'nis','student_number');
    }
}
