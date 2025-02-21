<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'description',
        'userID',
        'attachments',
        'status',
        'complete',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'attachments' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'complete' => 'boolean',
    ];

    /**
     * Get the user associated with the task.
     */
    public function user (): BelongsTo
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public  function overDue ()
    {
        return $this->complete == false && $this->end_date < Carbon::now();
    }

    public function due (): bool
    {
        return $this->end_date == Carbon::today();
    }


}
