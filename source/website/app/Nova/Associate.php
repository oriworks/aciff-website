<?php

namespace App\Nova;

use App\Nova\Actions\MarkAsSolved;
use App\Nova\Actions\MarkAsUnsolved;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Associate extends Resource
{
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Support';

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Associate>
     */
    public static $model = \App\Models\Associate::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'social_designation';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'social_designation',
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
            Text::make(__('Social Designation'), 'social_designation')->rules('required', 'max:254'),
            Textarea::make(__('Address'), 'address')->rules('required')->hideFromIndex(),
            Text::make(__('County'), 'county')->rules('required', 'max:254')->hideFromIndex(),
            Text::make(__('Parish'), 'parish')->rules('required', 'max:254')->hideFromIndex(),
            Text::make(__('Zip Code'), 'zip_code')->rules('required', 'max:254')->hideFromIndex(),
            Text::make(__('Locality'), 'locality')->rules('required', 'max:254')->hideFromIndex(),
            Text::make(__('Phone'), 'phone')->rules('required', 'max:254')->hideFromIndex(),
            Text::make(__('Fax'), 'fax')->rules('max:254')->hideFromIndex(),
            Text::make(__('Website'), 'website')->rules('max:254')->hideFromIndex(),
            Text::make(__('Email'), 'email')->rules('required', 'email', 'max:254')->hideFromIndex(),
            Text::make(__('NIF'), 'nif')->rules('required', 'max:254')->hideFromIndex(),
            Text::make(__('CAE'), 'cae')->rules('required', 'max:254')->hideFromIndex(),
            Select::make(__('Legal'), 'legal')->rules('required')
                ->options([
                    'plc' => __('Private limited company'),
                    'as' => __('Anonymous society'),
                    'ip' => __('Individual entrepreneur'),
                    'llc' => __('One-person limited liability company'),
                ])
                ->displayUsingLabels()
                ->hideFromIndex(),
            Text::make(__('Activity'), 'activity')->rules('required', 'max:254')->hideFromIndex(),
            Text::make(__('Joint Stock'), 'joint_stock')->rules('required', 'max:254')->hideFromIndex(),
            Text::make(__('Num Associates'), 'num_associates')->rules('required', 'max:254')->hideFromIndex(),
            Text::make(__('Num Employees'), 'num_employees')->rules('required', 'max:254')->hideFromIndex(),

            new Panel(__('Contact Person'), function () {
                return [
                    Text::make(__('Job'), 'contact_job')->rules('required', 'max:254'),
                    Text::make(__('Name'), 'contact_name')->rules('required', 'max:254'),
                    Text::make(__('Phone'), 'contact_phone')->rules('required', 'max:254'),
                    Text::make(__('Email'), 'contact_email')->rules('required', 'max:254'),
                ];
            }),
            new Panel(__('Payment of Quotas'), function () {
                return [
                    Select::make(__('Periodicity'), 'payment_periodicity')->rules('required')
                        ->options([
                            'yearly' => __('Yearly'),
                            'semiannual' => __('Semiannual'),
                            'quarterly' => __('Quarterly'),
                        ])
                        ->displayUsingLabels()
                        ->hideFromIndex(),
                    Select::make(__('Type'), 'payment_type')->rules('required')
                        ->options([
                            'in_store' => __('In Store'),
                            'bank_transfer' => __('Bank Transfer'),
                        ])
                        ->displayUsingLabels()
                        ->hideFromIndex(),
                ];
            }),
            new Panel(__('Consent'), function () {
                return [
                    Boolean::make(__('Consent'), 'consent')->hideFromIndex(),
                ];
            }),

            DateTime::make(__('Solved at'), 'solved_at')
                ->exceptOnForms(),

            BelongsTo::make(__('Solved by'), 'solvedBy', User::class)->exceptOnForms(),

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
            (new MarkAsSolved)->onlyInline(),
            (new MarkAsUnsolved)->onlyInline(),
        ];
    }
}
