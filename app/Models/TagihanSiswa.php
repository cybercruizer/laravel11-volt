<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TagihanSiswa extends Model
{
    use HasFactory;
    protected $connection='keuangan_db';
    protected $table = 'tb_siswa2425';
    protected $primaryKey= 'id';
    public $incrementing=false;
    protected $keyType = 'string';
    protected $guarded = [];
    protected $appends = ['total_tagihan'];

    public function getTotalTagihanAttribute()
    {
        $total = 0;
        foreach ($this->getAttributes() as $key => $value) {
            if (str_starts_with($key, 'tang_')) {
                $total += $value;
            }
        }
        return $total;
    }
    /**
     * Get the siswa that owns the TagihanSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'student_number', 'nis');
    }
}
