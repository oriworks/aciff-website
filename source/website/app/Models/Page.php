<?php

namespace App\Models;

use App\Models\Concerns\Keywordable;
use DOMDocument;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Urodoz\Truncate\TruncateService;

class Page extends Model implements HasMedia
{
    use HasFactory, HasUuids, HasSlug, InteractsWithMedia, Keywordable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'content',
        'view',
        'department_id',
        'keywords'
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

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('page_attachments');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function menuItem(): HasOne
    {
        return $this->hasOne(MenuItem::class);
    }

    public function getResumeAttribute()
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($this->content);
        $cleaner_input = str_replace(["\n", '<p></p>'], '', strip_tags($this->content, ['a', 'b', 'p', 'strong']));
        $truncateService = new TruncateService();

        return $truncateService->truncate($cleaner_input, 150);
    }

    public function getImagesAttribute()
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($this->content);

        $images = [];
        foreach ($dom->getElementsByTagName('img') as $image) {
            array_push($images, $image->getAttribute('src'));
        }

        return $images;
    }
}
