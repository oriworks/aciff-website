<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Oriworks\NewsletterSystem\Models\Concerns\Newsletterable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Notice extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia, Newsletterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'content',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments');
    }
}
