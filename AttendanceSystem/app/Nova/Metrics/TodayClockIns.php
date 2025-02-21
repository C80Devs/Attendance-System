<?php

namespace App\Nova\Metrics;

use App\Models\AttendanceModel;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;
use Carbon\Carbon;

class TodayClockIns extends Table
{
    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return mixed
     */
    public function calculate (NovaRequest $request)
    {
        // Get today's date
        $today = Carbon::today();

        $latestClockIns = AttendanceModel::with(['user' => function($query) {
            $query->select('id', 'firstName', 'lastName');
        }])
            ->whereDate('created_at', $today)
            ->orderBy('clockIn')
            ->get();

        $data = [];

        foreach ($latestClockIns as $attendance) {
            $clockInTime = Carbon::parse($attendance->clockIn)->format('H:i:s');
            $user = $attendance->user;

            $userLink = '/nova/resources/users/' . $user->id;
            $attendanceLink = '/nova/resources/attendances/' . $attendance->id;

            $data[] = MetricTableRow::make()
                ->icon('clock')
                ->title($user->firstName . ' ' . $user->lastName)
                ->subtitle("Clocked in at: $clockInTime");
                /*->actions(function() use ($userLink, $attendanceLink) {
                   return [
                        MenuItem::externalLink('View User', $userLink),
                        MenuItem::externalLink('View Attendance', $attendanceLink),
                    ];*/

        }

        return $data;
    }

}
