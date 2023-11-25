<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app['db.schema']->morphUsingUuids();
        view()->composer([
            'home',
            'page',
            'information',
            'components.layout',
            'mail::message'
        ], function ($view) {
            $view->with('entity', \App\Models\Entity::firstOrFail());
        });
        view()->composer([
            'components.layout'
        ], function ($view) {
            $view->with('menu', \App\Models\MenuItem::where('parent_id', null)->orderBy('sort_order')->get());
        });
        view()->composer([
            'home',
        ], function ($view) {
            $view->with('gallery', \App\Models\Gallery::where(function ($query) {
                $query->where('publish_to', '>', Carbon::now())
                    ->orWhereNull('publish_to');
            })
            ->get());
            $view->with('news', \App\Models\Information::where('publish_at', '<', Carbon::now())->orderByDesc('publish_at')->paginate(6));

            $view->with('banners', \App\Models\Banner::where('publish_at', '<', Carbon::now())->where(function ($query) {
                $query->where('publish_to', '>', Carbon::now())
                    ->orWhereNull('publish_to');
            })
            ->inRandomOrder()->limit(3)->get());
        });

        view()->composer(['page', 'information'], function ($view) {
            $view->with('banners', \App\Models\Banner::where('publish_at', '<', Carbon::now())->where(function ($query) {
                $query->where('publish_to', '>', Carbon::now())
                    ->orWhereNull('publish_to');
            })
            ->inRandomOrder()->limit(4)->get());
        });

        view()->composer(['protocols-and-partnerships'], function ($view) {
            $view->with('protocols', \App\Models\Partnership::where('type', 'protocol')->get()->groupBy(function ($item) {
                return $item->area->name;
            })->sortBy(function ($item, $key) {
                return $key;
            }));
            $view->with('partnerships', \App\Models\Partnership::where('type', 'partnership')->get()->groupBy(function ($item) {
                return $item->area->name;
            })->sortBy(function ($item, $key) {
                return $key;
            }));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
