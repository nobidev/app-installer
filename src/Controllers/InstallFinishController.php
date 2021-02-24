<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use AppInstaller;
use Illuminate\Http\Request;
use NobiDev\AppInstaller\Helpers\Helper;
use NobiDev\AppInstaller\Helpers\InstallHelper;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

/**
 * @package NobiDev\AppInstaller\Controllers
 */
class InstallFinishController extends InstallController
{
    public function index(Request $request): BaseResponse
    {
        if (InstallHelper::isReady()) {
            AppInstaller::setAsInstalled();
            return parent::index($request);
        }
        return redirect($this->getUrlNext($request->query()), ['install' => 'failed']);
    }

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
        return parent::getUrlNext() ?? route(Helper::resolveConfig('finished_route'),
                array_merge($parameters, ['install' => 'succeed'])
            );
    }
}
