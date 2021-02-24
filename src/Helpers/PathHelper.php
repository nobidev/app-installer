<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Helpers;

use Illuminate\Support\Facades\File;

/**
 * @package NobiDev\AppInstaller\Helpers
 */
class PathHelper
{
    public static function realPath(string $path): string
    {
        if (strncmp($path, DIRECTORY_SEPARATOR, 1) === 0) {
            return $path;
        }
        return base_path() . DIRECTORY_SEPARATOR . $path;
    }

    public static function checkWritableEnv(array &$result): void
    {
        $result['writable_env'] = [
            'is_ok' => File::isWritable(self::getEnvPath()),
        ];
    }

    public static function getEnvPath(): string
    {
        return base_path() . DIRECTORY_SEPARATOR . '.env';
    }
}
