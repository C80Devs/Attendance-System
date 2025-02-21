<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PollModel extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status'];

    protected $table = 'polls';

    public function options (): HasMany
    {
        return $this->hasMany(PollOption::class, 'poll_id', 'id');
    }
}
