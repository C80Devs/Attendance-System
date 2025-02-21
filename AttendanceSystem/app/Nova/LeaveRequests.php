<?php

namespace App\Nova;

use App\Models\LeaveModel;
use App\Models\User;
use App\Nova\Actions\ApproveDeclineLeave;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class LeaveRequests extends Resource
{
    public static $model = LeaveModel::class;

    public static $title = 'id'; // Use 'id' or a unique attribute here

    public static $search = [
        'id', 'reason', 'type',
    ];

    public static $with = ['user'];

    public function fields (NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            HasOne::make('Employee', 'getUser', \App\Nova\User::class),

            BelongsTo::make('User', 'user', \App\Nova\User::class)
                ->sortable(),

            Textarea::make('Reason')->nullable(),
            Badge::make('Approval Status', function() {
                return $this->approved === true ? 'Approved' : ($this->approved === false ? 'Declined' : 'Pending');
            })->map([
                'Approved' => 'success',
                'Declined' => 'danger',
                'Pending' => 'warning',
            ]),
            Text::make('Type')->sortable(),
            DateTime::make('Start Date', 'startDate')->sortable()->rules('required'),
            DateTime::make('End Date', 'endDate')->sortable()->rules('required'),
            new Panel('Additional Information', $this->additionalFields()),
        ];
    }

    protected function additionalFields ()
    {
        return [
            DateTime::make('Created At', 'created_at')->onlyOnDetail(),
            DateTime::make('Updated At', 'updated_at')->onlyOnDetail(),
        ];
    }

    public function actions (NovaRequest $request): array
    {
        return [
            new ApproveDeclineLeave(),
        ];
    }
}
