<?php

namespace App\Models;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Tahunajaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $connection = 'second_db';
    protected $table = 'classrooms';
    protected $primaryKey = 'class_id';
    //public function __construct(array $attributes = [])
    //{
    //    $this->table = env('SECOND_DB_DATABASE').'.'.$this->table;
    //    parent::__construct($attributes);
    //}
    /**
     * Get all of the siswa for the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'class_id');
    }
    /**
     * Get the tahunajaran that owns the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tahunajaran(): BelongsTo
    {
        return $this->belongsTo(Tahunajaran::class,'year_id');
    }
    /**
     * Get the user that owns the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'id','user_id');
    }
    /**
     * Get all of the presensis for the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function presensis(): HasMany
    {
        return $this->hasMany(Presensi::class, 'kelas_id');
    }
}
