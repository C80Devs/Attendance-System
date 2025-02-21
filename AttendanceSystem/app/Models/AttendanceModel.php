<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Nova\Actions\Actionable;

class AttendanceModel extends Model
{
    use HasFactory ,Actionable;

    protected $table = 'attendance';

    protected $fillable = [
        'userID',
        'device',
        'clockin_location',
        'clockout_location',
        'clockIn',
        'clockOut',
        'created_at',
        'updated_at'

    ];

    protected $casts = [
        'clockIn' => 'datetime',
        'clockOut' => 'datetime',
    ];

    /**
     * Get the user that owns the attendance record.
     */
    public function user (): BelongsTo
    {
        return $this->belongsTo(User::class, 'userID', 'id');
    }
}
