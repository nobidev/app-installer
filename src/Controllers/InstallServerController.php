<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use NobiDev\AppInstaller\Helpers\ServerHelper;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

/**
 * @package NobiDev\AppInstaller\Controllers
 */
class InstallServerController extends Controller
{

    public function index(): BaseResponse
    {
        return Response::view('installer::steps.server', ['checks' => ServerHelper::check()]);
    }
}
