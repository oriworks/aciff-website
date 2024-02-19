<?php

namespace App\Nova;

use App\Models\Document as ModelsDocument;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Mostafaznv\PdfOptimizer\Enums\PdfSettings;
use Mostafaznv\PdfOptimizer\Laravel\Facade\PdfOptimizer;
use Murdercode\TinymceEditor\TinymceEditor;


class Document extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Document>
     */
    public static $model = \App\Models\Document::class;

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
    public static $title = 'subject';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'subject', 'content'
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
            Text::make('Subject')
                ->sortable()
                ->rules('required', 'max:255', 'unique:documents,subject,{{resourceId}}'),

            Text::make('Slug')
                ->rules('required', 'max:255', 'unique:documents,slug,{{resourceId}}')
                ->onlyOnDetail(),

            TinymceEditor::make('Content'),

            BelongsTo::make('Category', 'category', Category::class)
                ->nullable(),


            Text::make('Pages', function () {
                    return $this->attachment_num_pages;
                })
                ->showOnIndex(),

            File::make('Attachment', 'attachment')
                ->storeOriginalName('attachment_name')
                ->storeSize('attachment_original_size')
                ->store(function (NovaRequest $request, \App\Models\Document $model) {
                    $originalFile = $request->attachment->store('/documents/original', 'private');
                    $compressFile = str_replace('documents/original/', 'documents/', $originalFile);

                    $result = PdfOptimizer::fromDisk('private')
                        ->open($originalFile)
                        ->toDisk('private')
                        ->settings(PdfSettings::SCREEN)
                        ->optimize($compressFile);

                    $compressQueueId = $result->queueId;

                    return [
                        'queue_id' => $compressQueueId,
                        'attachment' => $originalFile,
                        'attachment_name' => $request->attachment->getClientOriginalName(),
                        'attachment_original_size' => $request->attachment->getSize(),
                        'attachment_num_pages' => preg_match_all("/\/Page\W/", file_get_contents($request->attachment), $matches),
                        'attachment_pages' => [],
                    ];
                })
                ->acceptedTypes('.pdf'),


            BelongsTo::make('Creator', 'creator', User::class)->exceptOnForms(),
            DateTime::make('Created at')->onlyOnDetail(),
            BelongsTo::make('Last Editor', 'lastEditor', User::class)->exceptOnForms(),
            DateTime::make('Updated at')->onlyOnDetail(),


            DateTime::make(__('Publish At'), 'publish_at')->hideFromIndex(),
            DateTime::make(__('Download'), 'downloadable_at')->hideFromIndex(),
            DateTime::make(__('Request'), 'requestable_at')->hideFromIndex(),

            Boolean::make('Converted', 'converted')->exceptOnForms(),
            Text::make('Percentage', function (ModelsDocument $model) {
                return number_format($model->attachment_num_image / $model->attachment_num_pages * 100, 0) . '%';

            })->exceptOnForms(),
            Boolean::make(__('Published'), function ($model) {
                return $model->published && $model->converted;
            })->onlyOnIndex(),

            Boolean::make(__('Downloadable'), function ($model) {
                return $model->downloadable && $model->converted;
            })->onlyOnIndex(),

            Boolean::make(__('Requestable'), function ($model) {
                return $model->requestable;
            })->onlyOnIndex(),

            BelongsToMany::make('Tags', 'tags', Tag::class)
                ->showCreateRelationButton()
                ->hideFromIndex(),
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
            (new Actions\Publish)->sole(),
            (new Actions\Unpublish)->sole(),
            (new Actions\Downloadable)->sole(),
            (new Actions\RemoveDownloadable)->sole(),
            (new Actions\Requestable)->sole(),
            (new Actions\RemoveRequestable)->sole(),
        ];
    }
}
