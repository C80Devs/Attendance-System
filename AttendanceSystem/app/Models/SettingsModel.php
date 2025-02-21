<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsModel extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'settings';

    protected $fillable = [
        'color',
        'name',
        'no_of_leave_days',
        'task_active',
        'clock_active',
        'leave_active',
        'logo',
        'lat',
        'long',
    ];


    protected $casts = [
        'task_active' => 'boolean',
        'clock_active' => 'boolean',
        'leave_active' => 'boolean',
        'no_of_leave_days' => 'integer',
    ];

}
