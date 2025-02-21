<?php

namespace App\Nova\Metrics;

use App\Models\Task;
use Carbon\Carbon;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;

class TasksForToday extends Table
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $metrics = [];
        $tasks  = Task::where('start_date',Carbon::today())
            ->orwhere('end_date',Carbon::today())->with('user')->get();

        foreach ($tasks as $task){

            if ($task->end_date == Carbon::today()){
                $metrics[] = MetricTableRow::make()
                    ->icon('calendar')
                    ->iconClass($task->due() ? 'text-red-500' : 'text-green-500')
                    ->title($task->title)
                    ->subtitle($task->description . ' by ' . $task->user->firstName);
            }
            }
        return
           $metrics;
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }
}
