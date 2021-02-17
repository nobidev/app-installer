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
class InstallWelcomeController extends InstallController
{
    public function getContextData(Request $request): array
    {
        $policies = Helper::resolveConfigArray('policies');
        $help_url = Helper::resolveConfig('help_url');
        $purpose = __(Helper::resolveConfig('purpose_' . app()->getLocale()));

        return array_merge(
            parent::getContextData($request),
            compact('policies', 'purpose', 'help_url'),
        );
    }

    protected function getView(): ?string
    {
        return 'steps.welcome';
    }

    protected function getRouteNext(): ?string
    {
        return 'server';
    }
}
