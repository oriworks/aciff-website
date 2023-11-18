<?php

namespace Oriworks\NewsletterSystem;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NewsletterSystem extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::resources(
            collect(config('newsletter-system.resources'))->values()->all()
        );
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function menu(Request $request)
    {
        return self::mainMenuSection($request);
    }

    public static function mainMenuSection(Request $request)
    {
        return MenuSection::make('Newsletter',
            collect(config('newsletter-system.resources'))->map(function ($resource) {
                return MenuItem::resource($resource);
            })->all()
        )->icon('mail')->collapsable();
    }
}
