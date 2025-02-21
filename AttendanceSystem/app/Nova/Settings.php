<?php

namespace App\Nova;

use App\Models\SettingsModel;
use Laravel\Nova\Fields\Color;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class Settings extends Resource
{
    public static $model = SettingsModel::class;
    public static $title = 'name';
    public static $search = ['id', 'name'];

    public function fields (NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            // Use the NovaColorField for color pickers
            Color::make('Color')
                ->rules('required', 'max:255'),

            Color::make('Color Dark', 'color_dark')
                ->rules('required', 'max:255'),

            Number::make('No Of Leave Days', 'no_of_leave_days')
                ->sortable()
                ->rules('required', 'integer'),

            Boolean::make('Task Active', 'task_active'),
            Boolean::make('Clock Active', 'clock_active'),
            Boolean::make('Leave Active', 'leave_active'),

            Number::make('Closing Time', 'closing_time')
                ->sortable()
                ->rules('required', 'integer'),

            Text::make('Opening Time', 'opening_time')
                ->sortable()
                ->rules('required'),

            Boolean::make('Clock Out Anytime', 'clock_out_anytime'),

            Image::make('Logo')
                ->disk('public')
                ->nullable(),

            Number::make('Latitude', 'lat')
                ->step(0.000001)
                ->nullable(),

            Number::make('Longitude', 'long')
                ->step(0.000001)
                ->nullable(),

            DateTime::make('Created At')
                ->onlyOnDetail(),

            DateTime::make('Updated At')
                ->onlyOnDetail(),
        ];
    }
}
