<?php

namespace App\Models\Concerns;

use App\Models\Information;
use App\Models\Keyword;
use App\Models\Page;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;

trait Keywordable
{
    private static $_keywords = [];

    protected static function _before($model): void
    {
        self::$_keywords = $model->keywords;
        unset($model->keywords);
    }

    protected static function _after($model)
    {
        $keywordIds = [];
        foreach (self::$_keywords as $keyword) {
            $keywordModel = Keyword::where(['slug' => Str::slug($keyword)])->first();

            if (isset($keywordModel->id)) {
                array_push($keywordIds, $keywordModel->id);
            } else {
                $keywordModel = Keyword::firstOrCreate(['name' => $keyword]);
                array_push($keywordIds, $keywordModel->id);
            }
        }
        $model->keywords()->sync($keywordIds);
    }

    protected static function bootKeywordable()
    {
        static::creating(function ($model) {
            self::_before($model);
        });

        static::created(function ($model) {
            self::_after($model);
        });

        static::updating(function ($model) {
            self::_before($model);
        });

        static::updated(function ($model) {
            self::_after($model);
        });
    }

    public function keywords(): MorphToMany
    {
        return $this->morphToMany(Keyword::class, 'keywordable');
    }

    public function relatedInformationByTag() {
        return Information::whereHas('keywords', function ($q) {
            return $q->whereIn('name', $this->keywords->pluck('name'));
        })->where('id', '<>', $this->id);
    }

    public function relatedPagesByTag() {
        return Page::whereHas('keywords', function ($q) {
            return $q->whereIn('name', $this->keywords->pluck('name'));
        })->where('id', '<>', $this->id);
    }
}
