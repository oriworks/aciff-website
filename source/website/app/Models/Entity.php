<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Entity extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'friendly_name';
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('logo')
            ->singleFile();
    }

    /**
     * Get the departments for the entity.
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }
}
