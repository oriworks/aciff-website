<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class BannerJournal extends Pivot implements Sortable
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function buildSortQuery(): Builder
    {
        return static::query()->where('banner_id', $this->banner_id);
    }
}
