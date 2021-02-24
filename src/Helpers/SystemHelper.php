<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Helpers;

/**
 * @package NobiDev\AppInstaller\Helpers
 */
class SystemHelper extends Helper
{
    public static function getConfigMapping(): array
    {
        return array_merge(parent::getConfigMapping(), [
            'app_name' => 'app.name',
            'app_url' => 'app.url',
            'app_asset_url' => 'app.asset_url',
            'app_locale' => 'app.locale',
        ]);
    }

    public static function getResult(): array
    {
        $values = self::getValue();
        $result = [];
        PathHelper::checkWritableEnv($result);
        foreach ($values as $key => $value) {
            $result[$key] = [
                'value' => $value,
                'is_ok' => true,
            ];
        }

        return array_merge(parent::getResult(), $result);
    }
}
