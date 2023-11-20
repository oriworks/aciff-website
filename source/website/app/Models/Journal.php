<?php

namespace App\Models;

use App\Models\Pivots\BannerJournal;
use App\Models\Pivots\InformationJournal;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Oriworks\NewsletterSystem\Models\Concerns\Newsletterable;

class Journal extends Model
{
    use HasFactory, HasUuids, Newsletterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
    ];

    public function banners(): BelongsToMany
    {
        return $this->belongsToMany(Banner::class)
            ->using(BannerJournal::class)
            ->withPivot('sort_order');
    }

    public function information(): BelongsToMany
    {
        return $this->belongsToMany(Information::class)
            ->using(InformationJournal::class)
            ->withPivot('sort_order');
    }
}
