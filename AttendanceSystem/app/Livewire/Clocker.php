<?php

namespace App\Livewire;

use App\Models\AttendanceModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

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

    public function clock($latitude, $longitude): void
    {

        if ($latitude === null || $longitude === null) {
            session()->flash('error', 'Your location cannot be determined yet, Please wait or refresh..');
            return;

        }

        $googleMapsUrl = "https://www.google.com/maps?q={$latitude},{$longitude}";

        $user = Auth::user();
        $userId = $user->id;
        $today = now()->toDateString();

        // Check if the user already has a record for today
        $attendanceRecord = AttendanceModel::where('userID', $userId)
            ->whereDate('clockIn', $today)
            ->first() ;

        if ($attendanceRecord) {
            // If both clockIn and clockOut times are set, user cannot clock in again
            if ($attendanceRecord->clockIn && $attendanceRecord->clockOut) {
                session()->flash('error', 'You cannot perform any more clocking for today.');
            } else {
                // If record exists and clockOut time is not set, update the clockOut time
                $attendanceRecord->update(['clockOut' => now(), 'clockout_location' => $googleMapsUrl]);
                session()->flash('success', 'Clocked Out!');
            }
        } else {


            AttendanceModel::create([
                'userID' => $userId,
                'clockIn' => now(),
                'clockOut' => null,
                'device' => request()->userAgent(),
                'clockin_location' => $googleMapsUrl,
            ]);
            session()->flash('success', 'Clocked In!');
        }

        // Update clock status
        $this->updateClockStatus();
    }

    protected function updateClockStatus()
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
        $this->clockInTime = $attendanceRecord ? $attendanceRecord->clockIn : "N/A";
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
