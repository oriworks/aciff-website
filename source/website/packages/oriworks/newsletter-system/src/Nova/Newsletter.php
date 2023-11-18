<?php

namespace Oriworks\NewsletterSystem\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use Oriworks\NewsletterSystem\Nova\Pivots\MailingListNewsletterFields;

class Newsletter extends Resource
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
     * @var class-string<\Oriworks\NewsletterSystem\Models\Newsletter>
     */
    public static $model = \Oriworks\NewsletterSystem\Models\Newsletter::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'newsletterable.subject';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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
        self::$model = config('newsletter-system.models.newsletter');
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
            BelongsToMany::make('Sender', 'sender', config('newsletter-system.resources.sender'))
                ->nullable(),

            MorphTo::make('Newsletterable', 'newsletterable')
                ->types(collect(config('newsletter-system.newsletterable-types'))->keys()->all())
                ->showCreateRelationButton(),

            BelongsToMany::make('Mailing Lists', 'mailingLists', config('newsletter-system.resources.mailing_list'))
                ->fields(new MailingListNewsletterFields($this)),

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
