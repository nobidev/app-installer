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
 * @noinspection PhpClassNamingConventionInspection
 */
class InstallerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (AppInstaller::alreadyInstalled() || explode('/', $request->route() ? $request->route()->uri() : '')[0] !== 'install') {
            abort(404);
        }
        return $next($request);
    }
}
