<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayah';
    
    protected $fillable = [
        'code',
        'name'
    ];

    // Scope for provinces (2 digits)
    public function scopeProvinces($query)
    {
        return $query->whereRaw('LENGTH(REPLACE(code, ".", "")) = 2');
    }

    // Scope for regencies (4 digits total: 2 for province + 2 for regency)
    public function scopeRegencies($query)
    {
        return $query->whereRaw('LENGTH(REPLACE(code, ".", "")) = 4')
                    ->whereRaw('code LIKE "__.__"');
    }

    // Scope for districts (6 digits total)
    public function scopeDistricts($query)
    {
        return $query->whereRaw('LENGTH(REPLACE(code, ".", "")) = 6')
                    ->whereRaw('code LIKE "__.__.__"');
    }

    // Scope for villages (10 digits total)
    public function scopeVillages($query)
    {
        return $query->whereRaw('LENGTH(REPLACE(code, ".", "")) = 10')
                    ->whereRaw('code LIKE "__.__.__.____"');
    }
}