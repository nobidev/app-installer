<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use NobiDev\AppInstaller\Middleware\InstallerMiddleware;
use NobiDev\AppInstaller\Middleware\ToInstallMiddleware;

/**
 * @package NobiDev\AppInstaller
 */
class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        parent::register();
        $this->app->bind(Constant::getName(), AppInstaller::class);
        $this->mergeConfigFrom(__DIR__ . '/Configs/installer.php', 'installer');
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/Views', 'installer');
    }

    public function provides(): array
    {
        return parent::provides() + [
                Constant::getName(),
            ];
    }

    public function boot(Router $router, Kernel $kernel): void
    {
        $kernel->prependMiddlewareToGroup('web', ToInstallMiddleware::class);
        $router->pushMiddlewareToGroup('installer', InstallerMiddleware::class);
    }
}
