<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use Illuminate\Http\Request;
use NobiDev\AppInstaller\Helpers\InstallHelper;
use NobiDev\AppInstaller\Helpers\PermissionHelper;

/**
 * @package NobiDev\AppInstaller\Controllers
 */
class InstallPermissionController extends InstallController
{
    public function getContextData(Request $request): array
    {
        $result = PermissionHelper::getResult();
        $allow_next = InstallHelper::isPermissionReady();

        return array_merge(
            parent::getContextData($request),
            compact('result', 'allow_next'),
        );
    }

    protected function getView(): ?string
    {
        return 'steps.permission';
    }

    protected function getRouteNext(): ?string
    {
        return 'database';
    }
}
