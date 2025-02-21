<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PollOption extends Model
{
    use HasFactory;

    protected $table = 'poll_options';
    protected $fillable = ['poll_id', 'option', 'votes'];

    public function poll (): BelongsTo
    {
        return $this->belongsTo(PollModel::class, 'poll_id', 'id');
    }
}
