<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Murdercode\TinymceEditor\TinymceEditor;

class Partnership extends Resource
{
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Protocolos e Parcerias';

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Partnership>
     */
    public static $model = \App\Models\Partnership::class;

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
        'site',
        'email',
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
            Select::make(__('Type'), 'type')
                ->rules('required')
                ->options([
                    'protocol' => __('Protocol'),
                    'partnership' => __('Partnership'),
                ])
                ->displayUsingLabels()
                ->default('partnership'),

            BelongsTo::make(__('Area'), 'area', PartnershipArea::class)
                ->showCreateRelationButton(),

            Text::make(__('Name'), 'name')
                ->rules('required', 'max:254')
                ->creationRules('unique:partnerships,name')
                ->updateRules('unique:partnerships,name,{{resourceId}}'),

            Images::make(__('Logo'), 'partner_logo')
                ->showStatistics(),

            Text::make(__('Site'), 'site')
                ->rules('max:254')
                ->hideFromIndex(),

            Text::make(__('Email'), 'email')
                ->rules('max:254')
                ->hideFromIndex(),

            TinymceEditor::make(__('Benefits'), 'benefits')
                ->fullWidth(),

            TinymceEditor::make(__('Comments'), 'comments')
                ->fullWidth(),

            HasMany::make(__('Contacts'), 'contacts', PartnershipContact::class)->nullable(),

            HasMany::make(__('Addresses'), 'addresses', PartnershipAddress::class)->nullable(),
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
