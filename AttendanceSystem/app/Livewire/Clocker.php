<?php

namespace App\Livewire;

use App\Models\AttendanceModel;
use App\Models\SettingsModel;
use App\Models\User;
use Ballen\Distical\Calculator as DistanceCalculator;
use Ballen\Distical\Entities\LatLong;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Notifications\NovaNotification;
use Livewire\Component;
use Livewire\Livewire;

class Clocker extends Component
{
    public $clockedIn;
    public $clockedOut;
    public $clockInTime;
    public $clockOutTime;

    public function mount()
    {
        $this->updateClockStatus();
    }

    public function clock ($userLat, $userLng): void
    {
        $settings = SettingsModel::first();
        if (!$settings->clock_active) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Clock functionality is currently disabled.']);
            return;
        }

        if ($settings->lat === null || $settings->long === null) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Office coordinates have not been set. Please contact your administrator.']);
            return;
        }

        $currentTime = Carbon::now();

        if ($userLat === null || $userLng === null) {
            $this->dispatch('alert', ['type' => 'warning', 'message' => 'Your location cannot be determined. Please wait 5 seconds and refresh the page.']);
            return;
        }

        $officeLat = $settings->lat;
        $officeLng = $settings->long;

        $officeLocation = new LatLong($officeLat, $officeLng);
        $currentLocation = new LatLong($userLat, $userLng);
        $distanceCalculator = new DistanceCalculator($officeLocation, $currentLocation);
        $distance = $distanceCalculator->get()->asKilometres();
        $user = Auth::user();
        $userId = $user->id;
        $today = now()->toDateString();
        $googleMapsUrl = "https://www.google.com/maps?q=$userLat,$userLng";

        if ($distance > 0.3) {
            if (!$user->is_hybrid) {
                $this->dispatch('alert', ['type' => 'error', 'message' => 'You must be at the office to clock in or out.']);
                return;
            }

            $currentDay = strtolower($currentTime->format('l'));
            if (!in_array($currentDay, $user->days)) {
                $this->dispatch('alert', ['type' => 'error', 'message' => 'You are not scheduled for remote work today.']);
                return;
            }
        }

        // Proceed with clock in or clock out logic
        $attendanceRecord = AttendanceModel::where('userID', $userId)
            ->whereDate('clockIn', $today)
            ->first();

        if ($attendanceRecord) {
            // Clock out logic
            if ($attendanceRecord->clockIn && !$attendanceRecord->clockOut) {
                if ($settings->clock_out_anytime || $currentTime->greaterThanOrEqualTo(Carbon::today()->setTime($settings->closing_time, 0))) {
                    $attendanceRecord->update(['clockOut' => now(), 'clockout_location' => $googleMapsUrl]);
                    $this->dispatch('alert', ['type' => 'success', 'message' => 'Clocked Out!']);
                } else {
                    $this->dispatch('alert', ['type' => 'error', 'message' => 'You cannot clock out before closing time .']);
                }
            } else {
                $this->dispatch('alert', ['type' => 'error', 'message' => 'You cannot perform any more clocking for today.']);
            }
        } else {
            // Clock in logic
            AttendanceModel::create([
                'userID' => $userId,
                'clockIn' => now(),
                'clockOut' => null,
                'device' => request()->userAgent(),
                'clockin_location' => $googleMapsUrl,
            ]);

            $this->dispatch('alert', ['type' => 'success', 'message' => 'Clocked In!']);
        }

        $this->updateClockStatus();
    }


    protected function updateClockStatus(): void
    {
        $user = Auth::user();
        $userId = $user->id;
        $today = now()->toDateString();

        $this->dispatch('mapRefresh');

        // Check if the user already has a record for today
        $attendanceRecord = AttendanceModel::where('userID', $userId)
            ->whereDate('clockIn', $today)
            ->first();

        $this->clockedIn = $attendanceRecord && $attendanceRecord->clockIn && !$attendanceRecord->clockOut;
        $this->clockedOut = $attendanceRecord && $attendanceRecord->clockIn && $attendanceRecord->clockOut;
        $this->clockInTime = $attendanceRecord ? $attendanceRecord->clockIn->format('H:i a') : 'N/A';
        $this->clockOutTime = $attendanceRecord ? $attendanceRecord->clockOut : "N/A";
    }

    public function render()
    {

        // Retrieve today's attendance record for the current user
        $today = Carbon::now()->toDateString();

        $attendance = AttendanceModel::where('userID', Auth::id())
            ->whereDate('clockIn', $today)
            ->first();

        $location = null;
        $latitude = null;
        $longitude = null;

        if ($attendance && $attendance->clockin_location) {
            $location = $attendance->clockin_location;
            // Parse the Google Maps URL to extract latitude and longitude
            $urlParts = parse_url($location);

            if (isset($urlParts['query'])) {
                parse_str($urlParts['query'], $query);

                if (isset($query['q'])) {
                    $coordinates = explode(',', $query['q']);

                    if (count($coordinates) === 2) {
                        $latitude = $coordinates[0];
                        $longitude = $coordinates[1];

                    }
                }
            }
        }
        return view('livewire.clocker', compact('location','latitude','longitude'));
    }

}
