<?php

namespace App\Models;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\Tagihan;
use App\Models\Woroworo;
use App\Models\Pembayaran;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    protected $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function scopeWalikelas($query) {
        return $query->role('walikelas');
    }
    public function scopeGuru($query) {
        return $query->role('guru');
    }
    public function kelas(): HasOne
    {
        return $this->hasOne(Kelas::class);
    }
    /**
     * Get all of the siswas for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function siswas()
    {
        return $this->hasManyThrough(Siswa::class, Kelas::class,
        'user_id',
        'class_id',
        'id',
        'class_id'
    );
    }
    /**
     * Get all of the pengumumans for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function woroworos(): HasMany
    {
        return $this->hasMany(Woroworo::class);
    }
    /**
     * Get all of the pelanggarans for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pelanggarans(): HasMany
    {
        return $this->hasMany(Pelanggaran::class);
    }
    /**
     * Get all of the Tagihan for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagihan(): HasMany
    {
        return $this->hasMany(Tagihan::class);
    }
    /**
     * Get all of the pembayaran for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }
    /**
     * Get the kelas associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function jurusan(): HasOne
    {
        return $this->hasOne(Jurusan::class, 'user_id',);
    }
}
