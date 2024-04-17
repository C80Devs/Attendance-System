<?php

namespace App\Http\Controllers;

use App\Models\AttendanceModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $pageTitle = User::getFirstName() . "Dashboard";

        return view('dashboard',compact('pageTitle', ));
    }

    public function showActivity()
    {
        $pageTitle = User::getFirstName() . " Attendance Activity";
        $attendance = AttendanceModel::where('userID', Auth::id())->paginate(3);

        // Format clockIn and clockOut timestamps
        foreach ($attendance as $attend) {
            $attend->clockIn = $attend->clockIn ? Carbon::parse($attend->clockIn)->format('h:i:s A') : 'N/A';
            $attend->clockOut = $attend->clockOut ? Carbon::parse($attend->clockOut)->format('h:i:s A') : 'N/A';
            $attend->clockInHeader = $attend->clockIn ? Carbon::parse($attend->clockIn)->format('D d, M Y h:i A') : 'N/A';
        }
      //  $clockInLocationUrl = "https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center={$latitude},{$longitude}&zoom=15";

        $count = count($attendance) ?? 0;


        return view('activity', compact('pageTitle', 'attendance', 'count',));
    }

}
