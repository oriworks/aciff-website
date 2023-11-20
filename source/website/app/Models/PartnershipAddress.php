<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnershipAddress extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'value',
        'partnership_id',
    ];

    /**
     * Get the partnership that owns the address.
     */
    public function partnership(): BelongsTo
    {
        return $this->belongsTo(Partnership::class, 'partnership_id');
    }
}
