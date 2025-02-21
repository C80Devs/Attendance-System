<?php

namespace App\Nova\Metrics;

use App\Models\AttendanceModel;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use App\Models\Attendance;

// Assuming your model is called Attendance
use Illuminate\Support\Facades\DB;

class AverageWorkingHours extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return mixed
     */
    public function calculate (NovaRequest $request)
    {
        return $this->result(
            AttendanceModel::select(DB::raw('AVG(TIMESTAMPDIFF(HOUR, clockIn, clockOut)) as average_hours'))
                ->value('average_hours') ?? 0
        )->suffix('hours');
    }

    public function uriKey ()
    {
        return 'average-working-hours';
    }
}
