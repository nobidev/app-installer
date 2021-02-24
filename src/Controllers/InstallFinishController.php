<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use Illuminate\Http\Request;
use NobiDev\AppInstaller\Helpers\Helper;

/**
 * @package NobiDev\AppInstaller\Controllers
 */
class InstallFinishController extends InstallController
{
    public function getContextData(Request $request): array
    {
        $second = 5;
        return array_merge(parent::getContextData($request), compact('second'));
    }

    protected function getView(): ?string
    {
        return 'steps.finish';
    }

    protected function getRouteNext(): ?string
    {
        return null;
    }

    protected function getUrlNext(array $parameters = []): ?string
    {
        return parent::getUrlNext() ?? route(Helper::resolveConfig('finished_route'), $parameters);
    }
}
