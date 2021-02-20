<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use EnvManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use NobiDev\AppInstaller\Helpers\InstallHelper;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

/**
 * @package NobiDev\AppInstaller\Controllers
 */
class InstallDatabaseController extends Controller
{
    public function database(): BaseResponse
    {
        if (!InstallHelper::isSystemReady()) {
            return redirect()->route('AppInstaller::install.permission');
        }
        return Response::view('installer::steps.database');
    }

    public function setDatabase(Request $request): BaseResponse
    {
        try {
            $this->setEnv($request);
            return redirect()->route('AppInstaller::install.migrations');
        } catch (Exception $error) {
            return Response::view('installer::steps.database', ['values' => [], 'error' => $error->getMessage()]);
        }
    }

    public function setEnv(Request $request): void
    {
        // Database
        EnvManager::setKey('DB_HOST', $request->input('database_hostname'));
        EnvManager::setKey('DB_PORT', $request->input('database_port'));
        EnvManager::setKey('DB_DATABASE', $request->input('database_name'));
        EnvManager::setKey('DB_USERNAME', $request->input('database_username'));
        EnvManager::setKey('DB_PASSWORD', $request->input('database_password'));
        EnvManager::setKey('DB_PREFIX', $request->input('database_prefix'));

        // Admin
        EnvManager::setKey('ADMIN_EMAIL', $request->input('admin_email'));
        EnvManager::setKey('ADMIN_PASSWORD', $request->input('admin_password'));

        // App
        EnvManager::setKey('APP_NAME', $request->input('projectname'));
        EnvManager::setKey('APP_URL', $request->input('projecturl'));

        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Cache::flush();
    }

    public function migrations(): BaseResponse
    {
        if (!InstallHelper::isReady()) {
            return redirect()->route('AppInstaller::install.database');
        }
        return Response::view('installer::steps.migrations');
    }

    public function runMigrations(): BaseResponse
    {
        if (!InstallHelper::isReady()) {
            return redirect()->route('AppInstaller::install.database');
        }
        return $this->processRunMigrations();
    }

    protected function processRunMigrations(): BaseResponse
    {
        try {
            Artisan::call('migrate', ['--seed' => true]);
            return redirect()->route('AppInstaller::install.keys');
        } catch (Exception $error) {
            return Response::view('installer::steps.migrations', [
                'error' => $error->getMessage() ?: 'An error occurred while executing migrations'
            ]);
        }
    }
}
