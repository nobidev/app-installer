<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use EnvManager;
use Illuminate\Http\Request;
use NobiDev\AppInstaller\Helpers\DatabaseHelper;
use NobiDev\AppInstaller\Helpers\InstallHelper;

/**
 * @package NobiDev\AppInstaller\Controllers
 */
class InstallDatabaseController extends InstallController
{
    protected function setState(array $data): void
    {
        parent::setState($data);
        DatabaseHelper::setRuntime($data);
        if (InstallHelper::isDatabaseReady()) {
            $mapping = [
                'db_url' => 'DATABASE_URL',
                'db_host' => 'DB_HOST',
                'db_port' => 'DB_PORT',
                'db_name' => 'DB_DATABASE',
                'db_user' => 'DB_USERNAME',
                'db_password' => 'DB_PASSWORD',
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
        }
    }

    public function getContextData(Request $request): array
    {
        $result = DatabaseHelper::getResult();
        $allow_next = InstallHelper::isDatabaseReady();

        return array_merge(
            parent::getContextData($request),
            compact('result', 'allow_next'),
        );
    }

    protected function getView(): ?string
    {
        return 'steps.database';
    }

    protected function getRouteNext(): ?string
    {
        return 'migration';
    }
}
