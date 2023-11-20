<?php

namespace App\Models;

use App\Models\Concerns\Keywordable;
use App\Models\Pivots\InformationJournal;
use DOMDocument;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Oriworks\NewsletterSystem\Models\Concerns\Newsletterable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Urodoz\Truncate\TruncateService;

class Information extends Model implements HasMedia
{
    use HasFactory, HasUuids, HasSlug, InteractsWithMedia, Newsletterable, Keywordable;

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'content',
        'publish_at',
        'highlight_at',
        'highlight_to',
        'keywords'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'publish_at' => 'datetime',
        'highlight_at' => 'datetime',
        'highlight_to' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the department for the suggestion.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class)
            ->using(InformationJournal::class)
            ->withPivot('sort_order');
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
