<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Oriworks\NewsletterSystem\Models\Concerns\MailingListable;
use Oriworks\NewsletterSystem\Models\Concerns\MailingListableTrait;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Department extends MailingListable implements Sortable
{
    use HasFactory, HasUuids, MailingListableTrait, SortableTrait;

    protected $mailing_lists = ['Departamentos'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'friendly_name',
        'address',
        'zip_code',
        'locality',
        'phone',
        'fax',
        'website',
    ];

    protected static function booted()
    {
        self::creating(function (Department $model) {
            array_push($model->mailing_lists, $model->friendly_name);
            $model->mailing_lists = array_unique($model->mailing_lists);
        });

        self::updating(function (Department $model) {
            array_push($model->mailing_lists, $model->friendly_name);
            $model->mailing_lists = array_unique($model->mailing_lists);
        });
    }

    public function getFriendlyNameAttribute($value)
    {
        if ($value) {
            return $value;
        }
        return $this->name;
    }

    /**
     * Get the entity that owns the department.
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    /**
     * Get the suggestions for the department.
     */
    public function suggestions(): HasMany
    {
        return $this->hasMany(Suggestion::class);
    }
}
