<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Helpers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

/**
 * @package NobiDev\AppInstaller\Helpers
 */
class FolderHelper extends Controller
{
    public static function check(): array
    {
        return [
            'storage.framework' => (int)File::chmod('../storage/framework') >= 775,
            'storage.logs' => (int)File::chmod('../storage/logs') >= 775,
            'bootstrap.cache' => (int)File::chmod('../bootstrap/cache') >= 775,
            'public.uploads' => (int)File::chmod('../public/uploads') >= 775,
        ];
    }
}
