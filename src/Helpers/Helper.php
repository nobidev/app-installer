<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Helpers;

use NobiDev\AppInstaller\Constant;
use function in_array;

/**
 * @package NobiDev\AppInstaller\Helpers
 */
class Helper
{
    public static function resolveConfig(string $name, string $default = ''): string
    {
        return config(static::withNamespace($name, '.'), $default);
    }

    public static function resolveConfigArray(string $name, array $default = []): array
    {
        return config(static::withNamespace($name, '.'), $default);
    }

    public static function withNamespace(string $name, string $separator = '::'): string
    {
        return sprintf('%s%s%s', Constant::getName(), $separator, $name);
    }

    public static function getConfigMapping(): array
    {
        return [];
    }

    public static function getValue(): array
    {
        return array_map(static function ($item) {
            return config($item);
        }, static::getConfigMapping());
    }

    public static function setRuntime(array $data): void
    {
        $mapping = static::getConfigMapping();
        foreach ($data as $key => $value) {
            if (isset($mapping[$key])) {
                $config_key = $mapping[$key];
                config([$config_key => $value]);
            }
        }
    }

    public static function getResult(): array
    {
        $values = static::getValue();
        $result = [];
        foreach ($values as $key => $value) {
            $result[$key] = [
                'value' => $value,
                'is_ok' => true,
            ];
        }

        return $result;
    }

    public static function isOk(): bool
    {
        return !in_array(false, array_column(static::getResult(), 'is_ok'), true);
    }
}
