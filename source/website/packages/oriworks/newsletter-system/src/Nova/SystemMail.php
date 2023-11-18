<?php

namespace Oriworks\NewsletterSystem\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class SystemMail extends Resource
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
     * @var class-string<\Oriworks\NewsletterSystem\Models\SystemMail>
     */
    public static $model = \Oriworks\NewsletterSystem\Models\SystemMail::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'notification_type';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [];

    // public static $displayInNavigation = false;

    /**
     * Create a new resource instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model|null  $resource
     * @return void
     */
    public function __construct($resource = null)
    {
        parent::__construct($resource);
        self::$model = config('newsletter-system.models.system_mail');
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
            Select::make('Notification type')
                ->rules('required')
                ->options(collect(config('newsletter-system.notification-types'))->mapWithKeys(function ($item, $key) {
                    return [$item => $key];
                }))
                ->displayUsingLabels(),

            MorphTo::make('System Mailable', 'systemMailable')
                ->types(collect(config('newsletter-system.system-mailable-types'))->keys()->all())
                ->showCreateRelationButton()
                ->exceptOnForms()
                ->nullable(),

            HasMany::make('Mail Queues', 'mailQueues', config('newsletter-system.resources.mail_queue')),
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
