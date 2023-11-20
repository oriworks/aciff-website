<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Banner extends Resource
{
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Website';

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Banner>
     */
    public static $model = \App\Models\Banner::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make(__('Name'), 'name')
                ->rules('required', 'max:254')
                ->creationRules('unique:banners,name')
                ->updateRules('unique:banners,name,{{resourceId}}'),

            Images::make(__('Banner'), 'banner')
                ->showStatistics()
                ->rules('required'),

            Select::make(__('Position'), 'position')
                ->rules('required')
                ->options([
                    'bottom' => __('Bottom'),
                    'side' => __('Side'),
                ])
                ->displayUsingLabels()
                ->default('bottom'),

            Text::make(__('Link'), 'link')
                ->rules('required', 'max:254'),

            DateTime::make(__('Publish At'), 'publish_at'),
            DateTime::make(__('Publish To'), 'publish_to'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
