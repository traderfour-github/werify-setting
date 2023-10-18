<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SettingsRepositoryInterface;
use App\Repositories\SettingsRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind( SettingsRepositoryInterface::class, SettingsRepository::class );
    }
}
