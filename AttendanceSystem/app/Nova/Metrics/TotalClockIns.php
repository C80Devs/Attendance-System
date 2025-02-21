<?php

namespace App\Nova\Metrics;

use App\Models\AttendanceModel;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use App\Models\Attendance;

// Assuming your model is called Attendance

class TotalClockIns extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return mixed
     */
    public function calculate (NovaRequest $request)
    {
        return $this->count($request, AttendanceModel::class, 'clockIn');
    }

    /**
     * Get the range options for the metric.
     *
     * @return array
     */
    public function ranges ()
    {
        return [
            7 => 'Last 7 Days',
            30 => 'Last 30 Days',
            60 => 'Last 60 Days',
            365 => 'Last 365 Days',
            'ALL' => 'All Time',
        ];
    }

    public function uriKey ()
    {
        return 'total-clock-ins';
    }
}
