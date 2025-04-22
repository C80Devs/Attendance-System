<?php

namespace App\Http\Controllers;

use App\Models\AttendanceModel;
use App\Models\SettingsModel;
use Ballen\Distical\Calculator as DistanceCalculator;
use Ballen\Distical\Entities\LatLong;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public static function create($id): void
    {

        $settings = SettingsModel::first();
        $today = Carbon::today();

        if ($today->isWeekend()) {
            exit();
        }

        $existingRecord = AttendanceModel::where('userID', $id)
            ->whereDate('created_at', $today)
            ->first();
        if ($existingRecord) {
            exit();
        }

        $randomMinutes = rand(20, 59);

        $clockInTime = $today->setTime(8, 00)->addMinutes($randomMinutes);

        $clockInLocation = 'https://www.google.com/maps?q='.$settings->lat.','.$settings->long;

        AttendanceModel::create([
            'userID' => $id,
            'clockIn' => $clockInTime,
            'clockin_location' => $clockInLocation,
            'device' => 'Mozilla/5.0 (Linux; Android 13; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Mobile Safari/537.36',
            'created_at' => $clockInTime,
            'updated_at' => $clockInTime,
        ]);
    }

    public function faceClockin(Request $request)
    {
        $user = Auth::user();
        $settings = SettingsModel::first();

        if (! $settings->clock_active) {
            return response()->json(['error' => 'Clock functionality is currently disabled.'], 403);
        }

        if ($settings->lat === null || $settings->long === null) {
            return response()->json(['error' => 'Office coordinates have not been set. Please contact your administrator.'], 400);
        }

        $userLat = $request->latitude;
        $userLng = $request->longitude;

        if (! $userLat || ! $userLng) {
            return response()->json(['error' => 'Your location cannot be determined. Please enable location access.'], 400);
        }

        $officeLat = $settings->lat;
        $officeLng = $settings->long;
        $officeLocation = new LatLong($officeLat, $officeLng);
        $currentLocation = new LatLong($userLat, $userLng);
        $distanceCalculator = new DistanceCalculator($officeLocation, $currentLocation);
        $distance = $distanceCalculator->get()->asKilometres();

        $today = now()->toDateString();
        $googleMapsUrl = "https://www.google.com/maps?q=$userLat,$userLng";

        if ($distance > 0.1) {
            if (! $user->is_hybrid) {
                return response()->json(['error' => 'You must be at the office to clock in or out.'], 403);
            }

            $currentDay = strtolower(now()->format('l'));
            if (! in_array($currentDay, $user->days)) {
                return response()->json(['error' => 'You are not scheduled for remote work today.'], 403);
            }
        }

        $attendanceRecord = AttendanceModel::where('userID', $user->id)
            ->whereDate('clockIn', $today)
            ->first();

        if ($attendanceRecord) {
            if ($attendanceRecord->clockIn && ! $attendanceRecord->clockOut) {
                if ($settings->clock_out_anytime || now()->greaterThanOrEqualTo(Carbon::today()->setTime($settings->closing_time, 0))) {
                    $attendanceRecord->update(['clockOut' => now(), 'clockout_location' => $googleMapsUrl]);

                    return response()->json(['success' => 'Clocked Out!']);
                } else {
                    return response()->json(['error' => 'You cannot clock out before closing time.'], 403);
                }
            } else {
                return response()->json(['error' => 'You cannot perform any more clocking for today.'], 403);
            }
        } else {
            $faceImagePath = null;

            if ($request->hasFile('face_image')) {
                $faceImagePath = $request->file('face_image')->store('attendance_faces', 's3');
                $faceImagePath = Storage::disk('s3')->url($faceImagePath);
            }

            AttendanceModel::create([
                'userID' => $request->user_id,
                'clockIn' => now(),
                'clockOut' => null,
                'device' => $request->userAgent(),
                'type' => 'face',
                'clockin_location' => $googleMapsUrl,
                'face' => $faceImagePath,
            ]);

            return response()->json(['success' => 'Clocked In!']);
        }
    }
}
