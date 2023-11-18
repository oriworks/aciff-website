<?php

namespace Oriworks\NewsletterSystem\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Sender extends Resource
{
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Newsletter';

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\Oriworks\NewsletterSystem\Models\Sender>
     */
    public static $model = \Oriworks\NewsletterSystem\Models\Sender::class;

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
     * Create a new resource instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model|null  $resource
     * @return void
     */
    public function __construct($resource = null)
    {
        parent::__construct($resource);
        self::$model = config('newsletter-system.models.sender');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:254')
                ->creationRules('unique:senders,name')
                ->updateRules('unique:senders,name,{{resourceId}}'),

            Text::make('Email')
                ->sortable()
                ->rules('email', 'max:254'),

            Trix::make('Signature'),

            HasMany::make('Newsletters', 'newsletters'),
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
