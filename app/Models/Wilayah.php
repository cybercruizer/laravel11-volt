<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wilayah extends Model
{
    protected $table = 'wilayah';
    
    protected $fillable = [
        'code',
        'name'
    ];

    // Get parent wilayah
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'parent_code', 'code');
    }

    // Get child wilayah
    public function children(): HasMany
    {
        return $this->hasMany(Wilayah::class, 'parent_code', 'code');
    }

    // Get province level records
    public function scopeProvinces($query)
    {
        return $query->whereRaw('LENGTH(REPLACE(code, ".", "")) = 2');
    }

    // Get regency level records
    public function scopeRegencies($query)
    {
        return $query->whereRaw('LENGTH(REPLACE(code, ".", "")) = 5');
    }

    // Get district level records
    public function scopeDistricts($query)
    {
        return $query->whereRaw('LENGTH(REPLACE(code, ".", "")) = 8');
    }

    // Get village level records
    public function scopeVillages($query)
    {
        return $query->whereRaw('LENGTH(REPLACE(code, ".", "")) = 13');
    }

    // Get parent code
    public function getParentCodeAttribute()
    {
        $parts = explode('.', $this->code);
        array_pop($parts);
        return !empty($parts) ? implode('.', $parts) : null;
    }

    // Get level (province, regency, district, or village)
    public function getLevelAttribute()
    {
        $length = strlen(str_replace('.', '', $this->code));
        switch ($length) {
            case 2:
                return 'province';
            case 5:
                return 'regency';
            case 8:
                return 'district';
            case 13:
                return 'village';
            default:
                return 'unknown';
        }
    }

    // Get children of specific wilayah
    public function getChildrenByCode($code)
    {
        return self::where('code', 'like', $code . '.%')
            ->whereRaw('LENGTH(REPLACE(code, ".", "")) = ?', [
                strlen(str_replace('.', '', $code)) + 3
            ]);
    }

    // Get province data
    public function getProvince()
    {
        $provinceCode = explode('.', $this->code)[0];
        return self::where('code', $provinceCode)->first();
    }

    // Get regency data
    public function getRegency()
    {
        if ($this->level === 'province') return null;
        
        $parts = explode('.', $this->code);
        $regencyCode = $parts[0] . '.' . $parts[1];
        return self::where('code', $regencyCode)->first();
    }

    // Get district data
    public function getDistrict()
    {
        if (in_array($this->level, ['province', 'regency'])) return null;
        
        $parts = explode('.', $this->code);
        $districtCode = $parts[0] . '.' . $parts[1] . '.' . $parts[2];
        return self::where('code', $districtCode)->first();
    }
}