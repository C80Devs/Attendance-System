<?php

namespace App\Http\Controllers;

use App\Models\AnnouncementModel;
use App\Models\AttendanceModel;
use App\Models\LeaveModel;
use App\Models\SettingsModel;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function showDashboard (): View|Factory|Application
    {
        $settings = SettingsModel::first();
        $numberOfLeaveDays = $settings->no_of_leave_days;

        $pageTitle = User::getFirstName() . ' Dashboard';
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $upcomingBirthdays = User::whereMonth('date_of_birth', $currentMonth)
            ->get(['firstName', 'date_of_birth']);

        $numberOfWorkingDays = collect(
            Carbon::now()->startOfMonth()->daysUntil(Carbon::now()->endOfMonth())
        )
            ->filter(fn($date) => !$date->isWeekend())
            ->count();

        $userId = Auth::id();

        // Retrieve all attendances for the user this month
        $attendances = AttendanceModel::where('userID', $userId)
            ->whereMonth('clockIn', $currentMonth)
            ->whereYear('clockIn', $currentYear)
            ->get();

        $userAttendanceCount = $attendances->count();

        $userLeaveCount = LeaveModel::where('userID', $userId)
            ->whereYear('startDate', $currentYear)
            ->where('approved', true)
            ->count();

        $remainingLeaveDays = $numberOfLeaveDays - $userLeaveCount;



        $openingTime = Carbon::parse($settings->opening_time);

        $earlyAttendance = $attendances->filter(function($attendance) use ($openingTime) {
            $clockInTime = Carbon::parse($attendance->clockIn)->format('H:i:s');
            $formattedOpeningTime = $openingTime->format('H:i:s');
            return $clockInTime <= $formattedOpeningTime;
        })->count();

        $lateAttendance = $attendances->filter(function($attendance) use ($openingTime) {
            $clockInTime = Carbon::parse($attendance->clockIn)->format('H:i:s');
            $formattedOpeningTime = $openingTime->format('H:i:s');
            return $clockInTime > $formattedOpeningTime;
        })->count();

        $earlyAttendancePercentage = $userAttendanceCount > 0
            ? round(($earlyAttendance / $userAttendanceCount) * 100, 2)
            : 0;

        $topLeaveTypes = LeaveModel::whereYear('startDate', $currentYear)
            ->where('approved', true)
            ->where('userID', $userId)
            ->select('type', DB::raw('COUNT(*) as leave_count'))
            ->groupBy('type')
            ->orderBy('leave_count', 'DESC')
            ->limit(3)
            ->get();

        $totalTasks = Task::where('userID', $userId)->count();

        $completedTasks = Task::where('userID', $userId)
            ->where('complete', true)
            ->count();

        $ongoingTasks = Task::where('userID', $userId)
            ->where('end_date', '>', Carbon::now())
            ->count();

        $failedTasks = Task::where('userID', $userId)
            ->where('end_date', '<', Carbon::now())
            ->where('complete', false)
            ->count();

        $announcements = AnnouncementModel::orderBy('expires_at', 'desc')
                    ->take(10)->get();
                
                \Log::info('All announcements:', [
                    'count' => $announcements->count(),
                    'data' => $announcements->toArray()
                ]);

        return view('dashboard', compact(
            'pageTitle',
            'upcomingBirthdays',
            'announcements',
            'numberOfWorkingDays',
            'userAttendanceCount',
            'earlyAttendance',
            'lateAttendance',
            'earlyAttendancePercentage',
            'remainingLeaveDays',
            'topLeaveTypes',
            'totalTasks',
            'completedTasks',
            'ongoingTasks',
            'failedTasks'
        ));
    }


    public function showActivity ()
    {
        $pageTitle = User::getFirstName() . ' Attendance Activity';

        $attendance = AttendanceModel::where('userID', Auth::id())
            ->orderBy('clockIn', 'desc')
            ->paginate(5);

        foreach ($attendance as $attend) {
            $attend->clockInFormatted = $attend->clockIn ? Carbon::parse($attend->clockIn)->format('h:i:s A') : 'N/A';
            $attend->clockOutFormatted = $attend->clockOut ? Carbon::parse($attend->clockOut)->format('h:i:s A') : 'N/A';
            $attend->clockInHeader = $attend->clockIn ? Carbon::parse($attend->clockIn)->format('D d, M Y h:i A') : 'N/A';
        }

        $count = $attendance->count();

        return view('activity', compact('pageTitle', 'attendance', 'count'));
    }

    public function employees (Request $request): View|Factory|Application
    {
        $users = User::select('id','firstName', 'lastName', 'phone', 'email')->paginate(10);
        return view('employee-board', compact('users'));

    }




}
