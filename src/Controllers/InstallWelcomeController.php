<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

/**
 * @package NobiDev\AppInstaller\Controllers
 */
class InstallWelcomeController extends InstallController
{
    public function getContextData(): array
    {
        $policies = $this->resolveConfigArray('policies');
        $help_url = $this->resolveConfig('help_url');
        $purpose = __($this->resolveConfig('purpose_' . app()->getLocale()));

        return array_merge(
            parent::getContextData(),
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
