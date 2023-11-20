<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Keyword extends Model
{
    use HasFactory, HasUuids, HasSlug;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function information(): MorphToMany
    {
        return $this->morphedByMany(Information::class, 'keywordable');
    }

    public function pages(): MorphToMany
    {
        return $this->morphedByMany(Page::class, 'keywordable');
    }
}
