<?php

namespace App\Http\Controllers;

use App\Models\AttendanceModel;
use App\Models\SettingsModel;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public static function create ($id): void
    {

        $settings = SettingsModel::first();
        $today = Carbon::today();

        if ($today->isWeekend())
        {
            die();
        }

        $existingRecord = AttendanceModel::where('userID', $id)
            ->whereDate('created_at', $today)
            ->first();
        if ($existingRecord) {
            die();
        }

        $randomMinutes = rand(20, 59);

        $clockInTime = $today->setTime(8, 00)->addMinutes($randomMinutes);

        $clockInLocation = 'https://www.google.com/maps?q='.$settings->lat.",".$settings->long;

        AttendanceModel::create([
            'userID' => $id,
            'clockIn' => $clockInTime,
            'clockin_location' => $clockInLocation,
            'device' => 'Mozilla/5.0 (Linux; Android 13; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Mobile Safari/537.36',
            'created_at' =>$clockInTime,
            'updated_at' => $clockInTime,
        ]);
    }
}
