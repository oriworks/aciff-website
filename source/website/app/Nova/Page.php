<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Murdercode\TinymceEditor\TinymceEditor;
use Oriworks\MultipleInput\MultipleInput;

class Page extends Resource
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
     * @var class-string<\App\Models\Page>
     */
    public static $model = \App\Models\Page::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'subject';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'subject',
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
            Text::make(__('Subject'), 'subject')
                ->rules('required', 'max:254')
                ->creationRules('unique:pages,subject')
                ->updateRules('unique:pages,subject,{{resourceId}}'),

            Select::make(__('Template'), 'view')
                ->rules('required')
                ->options([
                    'home' => __('Home'),
                    'page' => __('Page'),
                    'membership-form' => __('Member Ship Form'),
                    'contact-form' => __('Contact Form'),
                    'information-list' => __('Information List'),
                    'protocols-and-partnerships' => __('Protocols and Partnerships')
                ])
                ->displayUsingLabels()
                ->default('page'),
                Text::make(__('Subject'), 'subject')
                ->rules('required', 'max:254')
                ->creationRules('unique:pages,subject')
                ->updateRules('unique:pages,subject,{{resourceId}}'),

            Select::make(__('Template'), 'view')
                ->rules('required')
                ->options([
                    'home' => __('Home'),
                    'page' => __('Page'),
                    'membership-form' => __('Member Ship Form'),
                    'contact-form' => __('Contact Form'),
                    'information-list' => __('Information List'),
                    'protocols-and-partnerships' => __('Protocols and Partnerships')
                ])
                ->displayUsingLabels()
                ->default('page'),

            TinymceEditor::make(__('Content'), 'content')
                ->rules('required')
                ->fullWidth(),

            MultipleInput::make(__('Keywords'), 'keywords')
                ->rules('required')
                ->listBy('name'),

            Files::make(__('Attachments'), 'page_attachments')
                ->setAllowedFileTypes(['application/pdf'])
                ->showStatistics()
                ->customPropertiesFields([
                    Boolean::make(__('Published'), 'published'),
                    Text::make(__('Description'), 'description'),
                ]),

            HasOne::make(__('Menu Item'), 'menuItem', MenuItem::class)
                ->nullable(),

            BelongsTo::make(__('Department'), 'department', Department::class)->nullable(),
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
