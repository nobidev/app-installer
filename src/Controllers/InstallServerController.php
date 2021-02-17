<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use Illuminate\Http\Request;
use NobiDev\AppInstaller\Helpers\InstallHelper;
use NobiDev\AppInstaller\Helpers\ServerHelper;

/**
 * @package NobiDev\AppInstaller\Controllers
 */
class InstallServerController extends InstallController
{
    public function getContextData(Request $request): array
    {
        $result = ServerHelper::getResult();
        $allow_next = InstallHelper::isServerReady();

        return array_merge(
            parent::getContextData($request),
            compact('result', 'allow_next'),
        );
    }

    protected function getView(): ?string
    {
        return 'steps.server';
    }

    protected function getRouteNext(): ?string
    {
        return 'folders';
    }
}
