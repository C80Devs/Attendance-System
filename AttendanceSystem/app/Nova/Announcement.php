<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Resource;
use Laravel\Nova\Http\Requests\NovaRequest;


class Announcement extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\AnnouncementModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'message';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'message'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields (NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Message')
                ->sortable()
                ->rules('required', 'max:255'),
            DateTime::make('Expires At')
                ->rules('required', 'date'),
            DateTime::make('Created At')
                ->onlyOnDetail(),
            DateTime::make('Updated At')
                ->onlyOnDetail(),
        ];
    }
}