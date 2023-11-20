<?php

namespace App\Models;

use App\Models\Pivots\BannerJournal;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Banner extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'publish_at',
        'publish_to',
        'position',
        'link',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'publish_at' => 'datetime',
        'publish_to' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banner')->singleFile();
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class)
            ->using(BannerJournal::class)
            ->withPivot('sort_order');
    }
}
