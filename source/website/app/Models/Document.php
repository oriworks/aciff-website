<?php

namespace App\Models;

use App\Traits\HasBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Document extends Model implements HasMedia
{
    use HasFactory, HasUuids, HasBy, HasSlug, InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('document')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                if ($media->getTypeFromMime() === 'pdf') {
                    $pdf = new \Spatie\PdfToImage\Pdf($media->getPath());
                    foreach (range(1, $pdf->getNumberOfPages()) as $pageNumber) {
                        $this->addMediaConversion('page-' . $pageNumber)
                            ->watermark(public_path('/img/logo.png'))
                            ->watermarkOpacity(30)
                            ->watermarkWidth(50, Manipulations::UNIT_PERCENT)
                            ->watermarkPosition(Manipulations::POSITION_CENTER)
                            ->pdfPageNumber($pageNumber)
                            ->queued();
                    }
                }
            });
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('subject')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Tag::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function lastEditor(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
}
