<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use NobiDev\AppInstaller\Helpers\FolderHelper;
use NobiDev\AppInstaller\Helpers\InstallHelper;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

/**
 * @package NobiDev\AppInstaller\Controllers
 * @noinspection PhpClassNamingConventionInspection
 */
class InstallFolderController extends Controller
{
    public function index(): BaseResponse
    {
        if (!InstallHelper::isServerReady()) {
            return redirect()->route('AppInstaller::install.server');
        }
        return Response::view('installer::steps.folders', ['checks' => FolderHelper::check()]);
    }
}
