<?php

namespace App\Nova\Metrics;

use App\Models\AttendanceModel;
use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;
use Carbon\Carbon;

class HighestMonthlyClockIns extends Table
{
    /**
     * Calculate the value of the metric.
     *
     * @param NovaRequest $request
     * @return mixed
     */
    public function calculate (NovaRequest $request): mixed
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $users = User::select('users.id as userID', 'users.firstName', 'users.lastName')
            ->leftJoin('attendance', function($join) use ($currentYear, $currentMonth) {
                $join->on('users.id', '=', 'attendance.userID')
                    ->whereYear('attendance.created_at', $currentYear)
                    ->whereMonth('attendance.created_at', $currentMonth);
            })
            ->selectRaw('COUNT(attendance.userID) as clock_in_count')
            ->groupBy('users.id', 'users.firstName', 'users.lastName')
            ->orderByDesc('clock_in_count')
            ->get();

        $data = [];

        foreach ($users as $user) {
            $data[] = MetricTableRow::make()
                ->icon('clock')
                ->title($user->firstName . ' ' . $user->lastName)
                ->subtitle('Clock-ins: ' . $user->clock_in_count);
        }

        return $data;
    }
}
