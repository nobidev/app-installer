<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use NobiDev\AppInstaller\Middleware\InstallerMiddleware;
use NobiDev\AppInstaller\Middleware\ToInstallMiddleware;

/**
 * @package NobiDev\AppInstaller
 */
class ServiceProvider extends BaseServiceProvider
{
    protected string $webRouteGroup = 'web';

    public function register(): void
    {
        parent::register();
        $this->app->bind(Constant::getName(), AppInstaller::class);
        $this->mergeConfigFrom(__DIR__ . '/Configs/installer.php', Constant::getName());
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/Views', Constant::getName());
    }

    public function boot(Router $router, Kernel $kernel): void
    {
        $kernel->prependMiddlewareToGroup($this->webRouteGroup, ToInstallMiddleware::class);
        $router->pushMiddlewareToGroup(Constant::getName(), InstallerMiddleware::class);
        $this->loadTranslationsFrom(__DIR__ . '/Translations', Constant::getName());
    }
}
