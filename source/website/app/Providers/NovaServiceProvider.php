<?php

namespace App\Providers;

use App\Models\Entity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Http\Requests\NovaRequest;
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
            $entity = Entity::firstOrFail();
            return [
                    $menu->items[0],
                    MenuSection::make('Organization', [
                        MenuItem::make(
                            $entity->friendly_name,
                            "/resources/entities/{$entity->id}"
                        )->canSee(function (NovaRequest $request) {
                            return $request->user()->hasPermissionTo('entities.view');
                        }),
                        MenuItem::resource(\App\Nova\Department::class),
                    ], 'library')->collapsable(),

                    MenuSection::make('Website', [
                        MenuItem::resource(\App\Nova\Keyword::class),
                        MenuItem::resource(\App\Nova\Information::class),
                        MenuItem::resource(\App\Nova\Banner::class),
                        MenuItem::resource(\App\Nova\Gallery::class),
                        MenuItem::resource(\App\Nova\MenuItem::class),
                        MenuItem::resource(\App\Nova\Page::class),
                    ], 'globe-alt')->collapsable(),

                    MenuSection::make('Support', [
                        MenuItem::resource(\App\Nova\Suggestion::class)
                            ->withBadgeIf(
                                fn () => \App\Models\Suggestion::whereNull('solved_at')->count(),
                                'warning',
                                fn () => \App\Models\Suggestion::whereNull('solved_at')->count() > 0
                            ),
                        MenuItem::resource(\App\Nova\Associate::class)
                            ->withBadgeIf(
                                fn () => \App\Models\Associate::whereNull('solved_at')->count(),
                                'warning',
                                fn () => \App\Models\Associate::whereNull('solved_at')->count() > 0
                            ),
                    ], 'support')->collapsable(),

                    MenuSection::make('Partnerships', [
                        MenuItem::resource(\App\Nova\Partnership::class),
                        MenuItem::resource(\App\Nova\PartnershipArea::class),
                        MenuItem::resource(\App\Nova\PartnershipContact::class),
                        MenuItem::resource(\App\Nova\PartnershipAddress::class),
                    ], 'sparkles')->collapsable(),

                    MenuSection::make('Newsletter', [
                        MenuItem::resource(\Oriworks\NewsletterSystem\Nova\Newsletter::class),
                        MenuItem::resource(\App\Nova\Notice::class),
                        MenuItem::resource(\App\Nova\Flyer::class),
                        MenuItem::resource(\App\Nova\Information::class),
                        MenuItem::resource(\App\Nova\Journal::class),
                    ], 'mail')->collapsable(),

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
