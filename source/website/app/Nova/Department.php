<?php

namespace App\Nova;

use App\Rules\Emails;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Oriworks\MultipleInput\MultipleInput;

class Department extends Resource
{
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Organization';

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Department>
     */
    public static $model = \App\Models\Department::class;

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
        'friendly_name'
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
                ->sortable()
                ->rules('required', 'max:254')
                ->creationRules('unique:departments,name')
                ->updateRules('unique:departments,name,{{resourceId}}')
                ->hideFromIndex(),

            Text::make(__('Friendly Name'), 'friendly_name')
                ->sortable()
                ->rules('max:254'),

            MultipleInput::make(__('Emails'), 'emails')
                ->rules('required', new Emails)
                ->listBy('email'),

            new Panel(__('Contact'), function () {
                return [
                    Text::make(__('Address'), 'address')
                        ->rules('max:254')
                        ->hideFromIndex(),

                    Text::make(__('Zip Code'), 'zip_code')
                        ->rules('max:254')
                        ->hideFromIndex(),

                    Text::make(__('Locality'), 'locality')
                        ->rules('max:254')
                        ->hideFromIndex(),

                    Text::make(__('Phone'), 'phone')
                        ->rules('max:254')
                        ->hideFromIndex(),

                    Text::make(__('Fax'), 'fax')
                        ->rules('max:254')
                        ->hideFromIndex(),

                    Text::make(__('Website'), 'website')
                        ->rules('max:254')
                        ->hideFromIndex(),
                ];
            }),

            BelongsTo::make(__('Entity'), 'entity', Entity::class)->onlyOnForms(),

            HasMany::make(__('Suggestions'), 'suggestions', Suggestion::class)
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
