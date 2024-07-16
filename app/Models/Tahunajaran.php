<?php

namespace App\Models;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tahunajaran extends Model
{
    use HasFactory;
    protected $connection = 'second_db';
    protected $table = 'classyears';
    protected $guarded=[];
    protected $primaryKey='year_id';

    /**
     * Get all of the kelases for the Tahunajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kelases(): HasMany
    {
        return $this->hasMany(Kelas::class, 'year_id', 'year_id');
    }
}
