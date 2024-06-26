<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceModel extends Model
{
    use HasFactory;

    protected $table = "attendance";

    protected $fillable = ['userID', 'device','clockin_location','clockout_location','clockIn','clockOut'];


}
