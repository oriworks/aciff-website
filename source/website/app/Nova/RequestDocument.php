<?php

namespace App\Nova;

use App\Nova\Actions\MarkAsSolved;
use App\Nova\Actions\MarkAsUnsolved;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class RequestDocument extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\RequestDocument>
     */
    public static $model = \App\Models\RequestDocument::class;

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'History';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'content',
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
            BelongsTo::make(__('Document'), 'document', Document::class)
                ->rules('required'),

            Text::make(__('Name'), 'name')
                ->rules('required', 'max:254'),

            Text::make(__('Phone'), 'phone')
                ->rules('required', 'max:254'),

            Text::make(__('Email'), 'email')
                ->rules('required', 'email', 'max:254'),

            Textarea::make('Content'),

            DateTime::make(__('Solved at'), 'solved_at')
                ->exceptOnForms(),

            Text::make(__('Solved by'), 'solved_by')->exceptOnForms(),

            HasMany::make(__('Mail Queues'), 'mailQueues', config('newsletter-system.resources.mail_queue')),
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
        return [
            (new MarkAsSolved)->sole(),
            (new MarkAsUnsolved)->sole(),
        ];
    }
}
