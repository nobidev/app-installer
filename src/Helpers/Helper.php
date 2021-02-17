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
        return config(self::withNamespace($name, '.'), $default);
    }

    public static function resolveConfigArray(string $name, array $default = []): array
    {
        return config(self::withNamespace($name, '.'), $default);
    }

    public static function withNamespace(string $name, string $separator = '::'): string
    {
        return sprintf('%s%s%s', Constant::getName(), $separator, $name);
    }

    public static function getResult(): array
    {
        return [];
    }

    public static function isOk(): bool
    {
        return !in_array(false, array_column(self::getResult(), 'is_ok'), true);
    }
}
