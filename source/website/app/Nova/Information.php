<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Murdercode\TinymceEditor\TinymceEditor;
use Oriworks\MultipleInput\MultipleInput;

class Information extends Resource
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
     * @var class-string<\App\Models\Information>
     */
    public static $model = \App\Models\Information::class;

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
            BelongsTo::make(__('Department'), 'department', Department::class)
                ->nullable(),

            Text::make(__('Subject'), 'subject')
                ->rules('required', 'max:254')
                ->creationRules('unique:information,subject')
                ->updateRules('unique:information,subject,{{resourceId}}'),

            TinymceEditor::make(__('Content'), 'content')
                ->rules('required')
                ->fullWidth(),

            MultipleInput::make(__('Keywords'), 'keywords')
                ->rules('required')
                ->listBy('name'),

            Files::make(__('Attachments'), 'attachments')
                ->setAllowedFileTypes(['application/pdf']),

            DateTime::make(__('Publish At'), 'publish_at'),
            DateTime::make(__('Highlight At'), 'highlight_at'),
            DateTime::make(__('Highlight To'), 'highlight_to'),
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
