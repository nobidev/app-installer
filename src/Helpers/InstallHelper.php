<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Helpers;

use Illuminate\Support\Facades\DB;

/**
 * @package NobiDev\AppInstaller\Helpers
 */
class InstallHelper
{
    public static function isReady(): bool
    {
        return self::isSystemReady() && self::isDatabaseReady();
    }

    public static function isSystemReady(): bool
    {
        return self::isServerReady() && self::isPermissionReady();
    }

    public static function isServerReady(): bool
    {
        return ServerHelper::isOk();
    }

    public static function isPermissionReady(): bool
    {
        return PermissionHelper::isOk();
    }

    public static function isDatabaseReady(): bool
    {
        return (bool)DB::connection()->getPdo();
    }
}
