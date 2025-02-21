<?php

use App\Http\Controllers\AttendanceController;
use App\Jobs\UpdateAttendance;
use Illuminate\Support\Facades\Schedule;



Schedule::call(function(){
    AttendanceController::create(1);
})->dailyAt('09:00');

