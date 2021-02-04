<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use AppInstaller;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;
use NobiDev\AppInstaller\Helpers\InstallHelper;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

/**
 * @package NobiDev\AppInstaller\Controllers
 * @noinspection PhpClassNamingConventionInspection
 */
class InstallIndexController extends Controller
{
    public function index(): BaseResponse
    {
        return Response::view('installer::steps.welcome');
    }

    public function finish(): BaseResponse
    {
        if (empty(env('APP_KEY')) || !InstallHelper::isReady()) {
            return redirect()->route('AppInstaller::install.database');
        }
        AppInstaller::setAsInstalled();
        Artisan::call('route:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        return Response::view('installer::steps.finish');
    }
}
