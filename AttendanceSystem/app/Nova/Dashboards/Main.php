<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\AverageWorkingHours;
use App\Nova\Metrics\HighestMonthlyClockIns;
use App\Nova\Metrics\TasksForToday;
use App\Nova\Metrics\TodayClockIns;
use App\Nova\Metrics\TotalClockIns;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards(): array
    {
        return [
            new HighestMonthlyClockIns(),
            new TodayClockIns(),
            new TotalClockIns(),
            new AverageWorkingHours(),
            new TasksForToday(),
        ];
    }
}
