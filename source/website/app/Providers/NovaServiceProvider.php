<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::userMenu(function (Request $request, Menu $menu) {
            $menu->prepend(
                MenuItem::make(
                    'My Profile',
                    "/resources/users/{$request->user()->getKey()}"
                )
            );
            return $menu;
        });

        Nova::mainMenu(function (Request $request, Menu $menu) {
            // return $menu;
            return [
                    $menu->items[0],

                    MenuSection::make('History', [
                        MenuItem::resource(\App\Nova\Tag::class),
                        MenuItem::resource(\App\Nova\Category::class),
                        MenuItem::resource(\App\Nova\Document::class),
                    ], 'paper-clip')->collapsable(),

                    MenuSection::make('Security', [
                        MenuItem::resource(\App\Nova\User::class),
                        MenuItem::resource(\App\Nova\Role::class),
                        MenuItem::resource(\App\Nova\Permission::class),
                    ] ,'shield-check')->collapsable(),

                    \Oriworks\NewsletterSystem\NewsletterSystem::mainMenuSection($request),
            ];
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new \Oriworks\NewsletterSystem\NewsletterSystem,
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
