<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;

/**
 * @package NobiDev\AppInstaller\Helpers
 */
class DatabaseHelper extends Helper
{
    public static function getResult(): array
    {
        try {
            $pdo = DB::connection()->getPdo();
        } catch (PDOException $exception) {
            Log::error($exception->getMessage());
            $pdo = false;
        }

        return array_merge(parent::getResult(), [
            'connection' => [
                'is_ok' => (bool)$pdo,
            ]
        ]);
    }
}
