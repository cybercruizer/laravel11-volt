<?php

namespace App\Models;

use App\Models\Pelanggaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Penanganan extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * The penanganans that belong to the Penanganan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pelanggarans(): BelongsToMany
    {
        return $this->belongsToMany(Pelanggaran::class);
    }
}
