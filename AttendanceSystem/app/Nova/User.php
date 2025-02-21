<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MultiSelect;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\User>
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function title ()
    {
        return "$this->lastName $this->firstName";
    }
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'firstName', 'lastName', 'email', 'phone',
    ];


    public function fields (NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Gravatar::make()->maxWidth(50),

            Text::make('First Name', 'firstName')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Last Name', 'lastName')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Text::make('Phone')
                ->sortable()
                ->rules('required', 'max:15'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', Rules\Password::defaults())
                ->updateRules('nullable', Rules\Password::defaults()),

            Boolean::make('Super Admin', 'super_admin')
                ->trueValue('1')
                ->falseValue('0')
                ->sortable()
                ->rules('required'),


            Boolean::make('Account active', 'active')
                ->trueValue('1')
                ->falseValue('0')
                ->sortable()
                ->rules('required'),

            Boolean::make('Is Hybrid', 'is_hybrid')
                ->trueValue('1')
                ->falseValue('0')
                ->sortable()
                ->nullable(),

            Multiselect::make('Remote Days', 'days')
                ->options([
                    'monday' => 'Monday',
                    'tuesday' => 'Tuesday',
                    'wednesday' => 'Wednesday',
                    'thursday' => 'Thursday',
                    'friday' => 'Friday',
                    'saturday' => 'Saturday',
                    'sunday' => 'Sunday',
                ])
                ->nullable()
                ->help('Select the days the user works remotely. Leave blank if none.')
                ->dependsOn('is_hybrid', function($value) {
                    return $value === true;
                }),

            HasMany::make('Tasks', 'tasks', Tasks::class),
            HasMany::make('Monthly Attendance Record', 'monthlyAttendance', Attendance::class),
            HasMany::make('All Attendance Record', 'attendance', Attendance::class),
            HasMany::make('Leave Requests', 'Leaves', LeaveRequests::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function cards (NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function filters (NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function lenses (NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function actions (NovaRequest $request)
    {
        return [];
    }
}
