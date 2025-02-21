<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Nova\Actions\Actionable;

class LeaveModel extends Model
{
    use HasFactory, Actionable;

    protected $table = 'leave';

    protected $hidden = ['password', 'token'];

    protected $fillable = [
        'userID',
        'startDate',
        'endDate',
        'type',
        'reason',
        'approved',
    ];

    protected $casts = [
        'startDate' => 'date',
        'endDate' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'approved' => 'boolean',
    ];

    public function user (): HasOne
    {
        return $this->HasOne(User::class, 'id', 'userID');
    }

    public function getUser (): BelongsTo
    {
        return $this->BelongsTo(User::class, 'userID', 'id');
    }
}
