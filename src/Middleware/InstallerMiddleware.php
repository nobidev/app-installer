<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Middleware;

use AppInstaller;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * @package NobiDev\AppInstaller\Middleware
 * @noinspection PhpClassNamingConventionInspection
 */
class InstallerMiddleware
{
    public function handle(Request $request, Closure $next): RedirectResponse
    {
        if (AppInstaller::alreadyInstalled() || explode('/', $request->route() ? $request->route()->uri() : '')[0] !== 'install') {
            abort(404);
        }
        return $next($request);
    }
}
