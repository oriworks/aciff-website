<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class MenuItem extends Resource
{
    use HasSortableRows;

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Website';

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\MenuItem>
     */
    public static $model = \App\Models\MenuItem::class;

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
                ->creationRules('unique:menu_items,name')
                ->updateRules('unique:menu_items,name,{{resourceId}}'),

            BelongsTo::make(__('Parent'), 'parent', MenuItem::class)->nullable(),

            HasMany::make(__('Child'), 'child', MenuItem::class)->nullable(),

            BelongsTo::make(__('Page'), 'page', Page::class)->nullable(),

            Text::make(__('Link'), 'link')
                ->rules('max:254'),
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
