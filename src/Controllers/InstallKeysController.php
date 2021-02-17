<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use EnvManager;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;
use NobiDev\AppInstaller\Helpers\InstallHelper;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

/**
 * @package NobiDev\AppInstaller\Controllers
 */
class InstallKeysController extends Controller
{
    public function index(): BaseResponse
    {
        if (!InstallHelper::isReady()) {
            return redirect()->route('AppInstaller::install.database');
        }
        return Response::view('installer::steps.keys');
    }

    public function setKeys(): BaseResponse
    {
        if (!InstallHelper::isReady()) {
            return redirect()->route('AppInstaller::install.database');
        }
        return $this->processSetKeys();
    }

    protected function processSetKeys(): BaseResponse
    {
        try {
            if (!$this->generateKey()) {
                throw new RuntimeException('The application keys could not be generated.');
            }
            return redirect()->route('AppInstaller::install.finish');
        } catch (Exception $error) {
            return Response::view('installer::steps.keys', ['error' => $error->getMessage()]);
        }
    }

    protected function generateKey(): bool
    {
        Artisan::call('key:generate', ['--force' => true, '--show' => true]);
        if (empty(env('APP_KEY'))) {
            EnvManager::setKey('APP_KEY', trim(str_replace('"', '', Artisan::output())));
        }
        Artisan::call('storage:link');
        return !empty(env('APP_KEY'));
    }
}
