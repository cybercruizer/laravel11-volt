<?php

namespace App\Models;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Tagihan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran2425 extends Model
{
    use HasFactory;
    protected $connection = 'keuangan_db';
    // protected $table='db_transaksi2526';
    protected $table='db_transaksi2425';
    protected $guarded = [];
    protected $appends = ['pem_id'];
    public $timestamps=false;

    public function getkelasAttribute() {
        switch($this->attributes['tingkat']) {
            case 10:
                $tk= "X";
                break;
            case 11:
                $tk= "XI";
                break;
            case 12:
                $tk= "XII";
                break;
        }
        return $tk.$this->attributes['paralel'];
    }
    
    public function getPemIdAttribute() {
        return '2024/2025'.$this->attributes['jenis'].$this->attributes['jenjang'];
    }
    /**
     * Get the tahunajaran that owns the Pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tahunajaran(): BelongsTo
    {
        return $this->belongsTo(Tahunajaran::class, 'ta_id');
    }
    public function getTotalBayar($kode, $nis) {
        return $this->where([
            ['jenis',$kode],
            ['nis',$nis]
            ])->sum('jumlah');
    }
    /**
     * Get the siswa that owns the Pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'student_number', 'nis');
    }

    /**
     * Get the tagihan that owns the Pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class, 'kode','jenis');
    }

}
