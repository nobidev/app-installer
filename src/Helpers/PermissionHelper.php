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
class PermissionHelper extends Helper
{
    public static function getResult(): array
    {

        $result = [];
        foreach (self::resolveConfigArray('permissions') as $path => $required) {
            $realpath = PathHelper::realPath($path);
            if (File::exists($realpath)) {
                $value = File::chmod($realpath);
            } else {
                $value = 'false';
            }
            $is_ok = $value === $required;
            $result[$path] = compact('value', 'required', 'is_ok');
        }
        return array_merge(parent::getResult(), $result);
    }
}
