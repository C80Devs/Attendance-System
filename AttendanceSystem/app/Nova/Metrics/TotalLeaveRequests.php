<?php

namespace App\Nova\Metrics;

use App\Models\LeaveModel;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;

class TotalLeaveRequests extends Table
{
    public function calculate(NovaRequest $request): mixed
    {
        $currentYear = now()->year;

        $users = \App\Models\User::withCount(['leaves as approved_leaves_count' => function ($query) use ($currentYear) {
            $query->where('approved', true)
                ->whereYear('created_at', $currentYear);
        }])
            ->orderByDesc('approved_leaves_count')
            ->get();

        $data = [];

        foreach ($users as $user) {
            $data[] = MetricTableRow::make()
                ->icon('check-circle')
                ->title("{$user->firstName} {$user->lastName}")
                ->subtitle("Approved Leaves: {$user->approved_leaves_count}");
        }

        return $data;
    }

    public function name()
    {
        return 'Leave Requests This Year';
    }
}
