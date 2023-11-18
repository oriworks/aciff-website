<?php

namespace Oriworks\NewsletterSystem;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Nova;
use Oriworks\NewsletterSystem\Console\Commands\SendNewsletter;
use Oriworks\NewsletterSystem\Http\Middleware\Authorize;
use Oriworks\NewsletterSystem\Providers\EventServiceProvider;

class NewsletterSystemServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'oriworks');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'oriworks');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            //
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        /** @var CachesRoutes $app */
        $app = $this->app;
        if ($app->routesAreCached()) {
            return;
        }

        Nova::router(['nova', Authenticate::class, Authorize::class], 'newsletter-system')
            ->group(__DIR__.'/../routes/inertia.php');

        Route::middleware(['nova', Authorize::class])
            ->prefix('oriworks/newsletter-system')
            ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/newsletter-system.php', 'newsletter-system');

        // Register the service the package provides.
        $this->app->singleton('newsletter-system', function ($app) {
            return new NewsletterSystem;
        });

        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['newsletter-system'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/newsletter-system.php' => config_path('newsletter-system.php'),
        ], 'config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/oriworks'),
        ], 'newsletter-system.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/oriworks'),
        ], 'newsletter-system.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/oriworks'),
        ], 'newsletter-system.lang');*/

        // Publishing the migrations files.
        $this->publishes([
            __DIR__.'/../database/migrations/2021_11_12_000000_create_emails_table.php' => $this->getMigrationFileName('2021_11_12_000000', 'create_emails_table.php'),
            __DIR__.'/../database/migrations/2021_11_12_100000_create_mailing_lists_table.php' => $this->getMigrationFileName('2021_11_12_100000', 'create_mailing_lists_table.php'),
            __DIR__.'/../database/migrations/2021_11_12_200000_create_senders_table.php' => $this->getMigrationFileName('2021_11_12_200000', 'create_senders_table.php'),
            __DIR__.'/../database/migrations/2021_11_12_300000_create_newsletters_table.php' => $this->getMigrationFileName('2021_11_12_300000', 'create_newsletters_table.php'),
            __DIR__.'/../database/migrations/2021_11_12_400000_create_system_mails_table.php' => $this->getMigrationFileName('2021_11_12_400000', 'create_system_mails_table.php'),
        ], 'migrations');

        // Registering package commands.
        $this->commands([
            SendNewsletter::class
        ]);
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @return string
     */
    protected function getMigrationFileName($timestamp, $migrationFileName): string
    {
        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem, $migrationFileName) {
                return $filesystem->glob($path.'*_'.$migrationFileName);
            })
            ->push($this->app->databasePath()."/migrations/{$timestamp}_{$migrationFileName}")
            ->first();
    }
}
