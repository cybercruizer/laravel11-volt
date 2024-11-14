<?php

namespace App\Models;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Jurusan extends Model
{
    use HasFactory;
    protected $table = 'jurusan';
    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
     /* Get all of the comments for the Jurusan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    /**
     * Get all of the kelas for the Jurusan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'class_major', 'kode');
    }
    /**
     * Get all of the siswas for the Jurusan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function siswas(): HasManyThrough
    {
        return $this->hasManyThrough(Siswa::class, kelas::class,
        'class_major',
        'class_id',
        'kode',
        'class_id');
    }
}
