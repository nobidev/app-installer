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
    public static function findRootPath(): string
    {
        $root_path = __DIR__;
        while (strrpos($root_path, DIRECTORY_SEPARATOR) !== false) {
            if (File::exists($root_path . '/.env')) {
                break;
            }
            $root_path = substr($root_path, 0, strrpos($root_path, DIRECTORY_SEPARATOR));
        }
        return $root_path;
    }
}
