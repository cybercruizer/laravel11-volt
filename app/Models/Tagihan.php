<?php

namespace App\Models;

use App\Models\Siswa;
use App\Models\Tahunajaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tagihan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    { 
        return $this->belongsTo(User::class);
    }
    /**
     * Get the tahunajaran that owns the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /**
     * Get the siswa that owns the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
    public function tahunajaran(): BelongsTo
    {
        return $this->belongsTo(Tahunajaran::class,'ta_id');
    }
}
