<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Partnership extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'type',
        'name',
        'site',
        'email',
        'benefits',
        'comments',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('partner_logo')->singleFile();
    }

    /**
     * Get the area that owns the partnership.
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(PartnershipArea::class, 'area_id');
    }

    /**
     * Get the contacts for the partnership.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(PartnershipContact::class, 'partnership_id');
    }

    /**
     * Get the addresses for the partnership.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(PartnershipAddress::class, 'partnership_id');
    }
}
