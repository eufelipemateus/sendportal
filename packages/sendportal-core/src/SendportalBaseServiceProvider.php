<?php

namespace Sendportal\Base;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Sendportal\Base\Console\Commands\CampaignDispatchCommand;
use Sendportal\Base\Services\Sendportal;

class SendportalBaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('sendportal.php'),
            ], 'sendportal-config');

            $this->commands([
                CampaignDispatchCommand::class,
            ]);

            $this->app->booted(function () {
                $schedule = $this->app->make(Schedule::class);
                $schedule->command(CampaignDispatchCommand::class)->everyMinute()->withoutOverlapping();
            });
        }

        $this->loadJsonTranslationsFrom(resource_path('lang/vendor/sendportal'));
    }

    /**
     * Register the application services.
     */
    public function register()
    {
         // Facade.
        $this->app->bind('sendportal', static function (Application $app) {
            return $app->make(Sendportal::class);
        });

        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'sendportal');
    }
}
