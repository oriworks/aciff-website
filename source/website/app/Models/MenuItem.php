<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class MenuItem extends Model implements Sortable
{
    use HasFactory, HasUuids, SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
        'sort_on_has_many' => false,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'link',
        'sort_order'
    ];

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

}
