<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Middleware;

use AppInstaller;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package NobiDev\AppInstaller\Middleware
 */
class ToInstallMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!AppInstaller::alreadyInstalled() && explode('/', $request->route() ? $request->route()->uri() : '')[0] !== 'install') {
            return redirect()->route('AppInstaller::install.welcome');
        }
        return $next($request);
    }
}
