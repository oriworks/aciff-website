<?php

namespace App\Models;

use App\Traits\HasBy;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
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
        'attachment',
        'attachment_name',
        'attachment_num_pages',
        'attachment_original_size',
        'attachment_compress_size',
        'attachment_num_image',
        'attachment_pages',
        'queue_id',
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
        'attachment_pages' => 'array',
    ];

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
        return array_values($this->attachment_pages);
    }

    public function getConvertedAttribute() {
        return $this->attachment_num_pages === $this->attachment_num_image;
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
