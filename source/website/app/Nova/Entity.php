<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Entity extends Resource
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
     * @var class-string<\App\Models\Entity>
     */
    public static $model = \App\Models\Entity::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return \App\Models\Entity::firstOrFail()->friendly_name;
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return \App\Models\Entity::firstOrFail()->friendly_name;
    }

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
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

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
                ->creationRules('unique:entities,name')
                ->updateRules('unique:entities,name,{{resourceId}}'),

            Text::make(__('Friendly Name'), 'friendly_name')
                ->sortable()
                ->rules('max:254'),

            Images::make(__('Logo'), 'logo')
                ->showStatistics(),

            new Panel(__('Facebook'), function () {
                return [
                    Text::make(__('Account Name'), 'facebook'),

                    Boolean::make(__('Like'), 'facebook_like'),

                    Boolean::make(__('Share'), 'facebook_share'),
                ];
            }),
            new Panel(__('Twitter'), function () {
                return [
                    Text::make(__('Account Name'), 'twitter'),

                    Boolean::make(__('Like'), 'twitter_like'),

                    Boolean::make(__('Share'), 'twitter_share'),
                ];
            }),
            new Panel(__('Instagram'), function () {
                return [
                    Text::make(__('Account Name'), 'instagram'),

                    Boolean::make(__('Like'), 'instagram_like'),

                    Boolean::make(__('Share'), 'instagram_share'),
                ];
            }),
            new Panel(__('Linked In'), function () {
                return [
                    Text::make(__('Account Name'), 'linked_in'),

                    Boolean::make(__('Like'), 'linked_in_like'),

                    Boolean::make(__('Share'), 'linked_in_share'),
                ];
            }),
            new Panel(__('Email'), function () {
                return [
                    Boolean::make(__('Share'), 'email_share'),
                ];
            }),

            HasMany::make(__('Departments'), 'departments', Department::class),
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
