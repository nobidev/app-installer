<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use EnvManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use NobiDev\AppInstaller\Helpers\SystemHelper;
use ResourceBundle;

/**
 * @package NobiDev\AppInstaller\Controllers
 */
class InstallSystemController extends InstallController
{
    protected bool $allow_next = false;

    protected function setState(array $data): void
    {
        parent::setState($data);
        SystemHelper::setRuntime($data);
        $mapping = [
            'app_name' => 'APP_NAME',
            'app_url' => 'APP_URL',
            'app_asset_url' => 'ASSET_URL',
            'locale' => 'APP_LOCALE',
            'is_demo' => 'IS_DEMO',
        ];
        foreach ($data as $key => $value) {
            if (!isset($mapping[$key])) {
                continue;
            }
            $env = $mapping[$key];
            if ($env && $value) {
                EnvManager::setKey($env, $value);
            }
        }
        EnvManager::save();
        $this->allow_next = Artisan::call('key:generate --ansi') === 0;
    }

    public function getContextData(Request $request): array
    {
        $result = SystemHelper::getResult();
        $allow_next = $this->allow_next;
        $locales = [];
        foreach (ResourceBundle::getLocales('') as $locale) {
            $language = locale_get_display_language($locale, app()->getLocale());
            $region = locale_get_display_region($locale, app()->getLocale());
            if ($region) {
                continue;
            }
            $locales[$locale] = $language;
        }

        return array_merge(
            parent::getContextData($request),
            compact('result', 'allow_next', 'locales'),
        );
    }

    protected function getView(): ?string
    {
        return 'steps.system';
    }

    protected function getRouteNext(): ?string
    {
        return 'owner';
    }
}
