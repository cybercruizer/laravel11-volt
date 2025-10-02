<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RFIDLog extends Model
{
    use HasFactory;

    protected $table = 'rfid_logs';

    protected $fillable = [
        'device_id',
        'rfid_uid',
        'student_id',
        'scanned_at',
        'success',
        'message',
        'ip_address'
    ];

    protected $casts = [
        'success' => 'boolean',
        'scanned_at' => 'datetime',
    ];

    /**
     * Get the user associated with this log
     */
    public function siswa() : BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Scope for successful scans only
     */
    public function scopeSuccessful($query)
    {
        return $query->where('success', true);
    }

    /**
     * Scope for failed scans only
     */
    public function scopeFailed($query)
    {
        return $query->where('success', false);
    }

    /**
     * Scope for specific device
     */
    public function scopeForDevice($query, $deviceId)
    {
        return $query->where('device_id', $deviceId);
    }

    /**
     * Scope for date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('scanned_at', [$startDate, $endDate]);
    }
}