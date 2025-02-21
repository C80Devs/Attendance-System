<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotesModel extends Model
{
    use HasFactory;

    protected $table = 'votes';

    protected $fillable = ['user_id', 'poll_option_id', 'poll_id'];

    // Define relationships if needed
    public function pollOption ()
    {
        return $this->belongsTo(PollOption::class, 'poll_option_id');
    }

    public function poll ()
    {
        return $this->belongsTo(PollModel::class, 'poll_id');
    }
}
