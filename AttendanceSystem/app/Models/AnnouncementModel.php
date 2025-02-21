<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AnnouncementModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'announcements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message',
        'expires_at',
        'created_at',
        'updated_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Automatically cast the following fields to Carbon instances.
     *
     * @var array
     */
    protected $dates = [
        'expires_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
    /**
     * Scope to get active announcements that haven't expired.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('expires_at', '>=', Carbon::now());
    }

    /**
     * Check if the announcement is still active (not expired).
     *
     * @return bool
     */
    public function isActive (): bool
    {
        return Carbon::now()->lt($this->expires_at);
    }
}
