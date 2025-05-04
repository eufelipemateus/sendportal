<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\QuotaServiceInterface;
use App\Repositories\Campaigns\CampaignTenantRepositoryInterface;
use App\Repositories\Campaigns\MySqlCampaignTenantRepository;
use App\Repositories\Campaigns\PostgresCampaignTenantRepository;
use App\Repositories\Messages\MessageTenantRepositoryInterface;
use App\Repositories\Messages\MySqlMessageTenantRepository;
use App\Repositories\Messages\PostgresMessageTenantRepository;
use App\Repositories\Subscribers\MySqlSubscriberTenantRepository;
use App\Repositories\Subscribers\PostgresSubscriberTenantRepository;
use App\Repositories\Subscribers\SubscriberTenantRepositoryInterface;
use App\Services\Helper;
use App\Services\QuotaService;
use App\Traits\ResolvesDatabaseDriver;
use App\Services\Sendportal;

class SendportalAppServiceProvider extends ServiceProvider
{
    use ResolvesDatabaseDriver;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Campaign repository.
        $this->app->bind(CampaignTenantRepositoryInterface::class, function (Application $app) {
            if ($this->usingPostgres()) {
                return $app->make(PostgresCampaignTenantRepository::class);
            }

            return $app->make(MySqlCampaignTenantRepository::class);
        });

        // Message repository.
        $this->app->bind(MessageTenantRepositoryInterface::class, function (Application $app) {
            if ($this->usingPostgres()) {
                return $app->make(PostgresMessageTenantRepository::class);
            }

            return $app->make(MySqlMessageTenantRepository::class);
        });

        // Subscriber repository.
        $this->app->bind(SubscriberTenantRepositoryInterface::class, function (Application $app) {
            if ($this->usingPostgres()) {
                return $app->make(PostgresSubscriberTenantRepository::class);
            }

            return $app->make(MySqlSubscriberTenantRepository::class);
        });

        $this->app->bind(QuotaServiceInterface::class, QuotaService::class);

        $this->app->bind('sendportal', static function (Application $app) {
            return $app->make(Sendportal::class);
        });

        $this->app->singleton('sendportal.helper', function () {
            return new Helper();
        });     
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
