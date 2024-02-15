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

    protected $fillable = [
        'subject',
        'content',
        'publish_at',
        'downloadable_at',
        'requestable_at',
        'category_id',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'publish_at' => 'datetime',
        'downloadable_at' => 'datetime',
        'requestable_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('document')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {

                if ($media->getTypeFromMime() === 'pdf') {
                    $pdf = new \Spatie\PdfToImage\Pdf($media->getPath());
                    foreach (range(1, $pdf->getNumberOfPages()) as $pageNumber) {
                        $this->addMediaConversion('page-' . $pageNumber)
                            ->watermark(public_path('/img/logo_white.png'))
                            ->watermarkOpacity(50)
                            ->watermarkWidth(40, Manipulations::UNIT_PERCENT)
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

    public function getPagesAttribute() {
        $media = $this->getMedia('document');
        if (count($media) === 0) {
            return [];
        }
        $document = $media[0];
        $path = $document->getAvailableFullUrl(['page-1']);

        return array_map(function($conversion) use ($path) {
            return str_replace('page-1', $conversion, $path);
        }, array_keys($document->generated_conversions));
    }

    public function getMediaPagesAttribute() {
        $media = $this->getMedia('document');
        if (count($media) === 0) {
            return [];
        }
        $document = $media[0];
        $path = $document->getAvailablePath(['page-1']);

        return array_map(function($conversion) use ($path) {
            return str_replace('page-1', $conversion, $path);
        }, array_keys($document->generated_conversions));
    }

    public function getConvertedAttribute() {
        $media = $this->getMedia('document');
        if (count($media) === 0) {
            return false;
        }
        return count($media[0]->generated_conversions) > 0;
    }

    public function getPublishedAttribute() {
        return $this->publish_at && $this->publish_at->isPast();
    }

    public function getDownloadableAttribute() {
        return $this->downloadable_at && $this->downloadable_at->isPast();
    }

    public function getRequestableAttribute() {
        return $this->requestable_at && $this->requestable_at->isPast();
    }
}
