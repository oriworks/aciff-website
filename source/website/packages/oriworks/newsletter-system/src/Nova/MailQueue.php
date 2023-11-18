<?php

namespace Oriworks\NewsletterSystem\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class MailQueue extends Resource
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
     * @var class-string<\Oriworks\NewsletterSystem\Models\Pivots\MailQueue>
     */
    public static $model = \Oriworks\NewsletterSystem\Models\Pivots\MailQueue::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'mailable.notification_type';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [];

    protected static $sort = false;

    /**
     * Create a new resource instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model|null  $resource
     * @return void
     */
    public function __construct($resource = null)
    {
        parent::__construct($resource);
        self::$model = config('newsletter-system.models.mail_queue');
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
            MorphTo::make('Email', 'emailable')
                ->types(collect(config('newsletter-system.emailable-types'))->values()->all())
                ->nullable(),

            Boolean::make('Verified', function () {
                return $this->emailable_type !== config('newsletter-system.models.email') || isset($this->emailable->verified_at);
            }),
            Boolean::make('Canceled', function () {
                return isset($this->emailable->canceled_at);
            }),

            MorphTo::make('Mail', 'mailable')
                ->types(collect(config('newsletter-system.mailable-types'))->values()->all())
                ->nullable(),

            Boolean::make('Sent', function () {
                return isset($this->sent_at);
            }),

            Boolean::make('Delivered', function () {
                return isset($this->delivered_at);
            }),

            Boolean::make('Viewed', function () {
                return isset($this->viewed_at);
            }),

            Number::make('Priority', 'priority'),

            Number::make('Retry', 'retry'),
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
