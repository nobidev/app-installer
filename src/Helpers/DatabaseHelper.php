<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Helpers;

use PDO;
use PDOException;

/**
 * @package NobiDev\AppInstaller\Helpers
 */
class DatabaseHelper extends Helper
{
    public const MYSQL_ERROR_CONNECTION = 2002;
    public const MYSQL_ERROR_CREDENTIAL = 1045;
    public const MYSQL_ERROR_SELECT_DATABASE = 1049;

    protected static function getConnectionConfigKey(string $key, string $name = 'mysql'): string
    {
        return sprintf('database.connections.%s.%s', $name, $key);
    }

    public static function getConfigMapping(): array
    {
        return array_merge(parent::getConfigMapping(), [
            'db_url' => self::getConnectionConfigKey('url'),
            'db_host' => self::getConnectionConfigKey('host'),
            'db_port' => self::getConnectionConfigKey('port'),
            'db_name' => self::getConnectionConfigKey('database'),
            'db_user' => self::getConnectionConfigKey('username'),
            'db_password' => self::getConnectionConfigKey('password'),
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
        try {
            new PDO(
                sprintf('mysql:host=%s;port=%s;dbname=%s', $values['db_host'], $values['db_port'], $values['db_name']),
                $values['db_user'], $values['db_password'],
            );
            $result['connection'] = [
                'value' => 'Ok',
                'is_ok' => true,
            ];
        } catch (PDOException $exception) {
            $result['connection'] = [
                'value' => $exception->getMessage(),
                'is_ok' => false,
            ];
            foreach (array_keys($values) as $key) {
                if (!$result[$key]['is_ok']) {
                    continue;
                }
                switch ($key) {
                    case 'db_host':
                    case 'db_port':
                        $result[$key]['is_ok'] = $exception->getCode() !== self::MYSQL_ERROR_CONNECTION;
                        break;
                    case 'db_name':
                        $result[$key]['is_ok'] = $exception->getCode() !== self::MYSQL_ERROR_SELECT_DATABASE;
                        break;
                    case 'db_user':
                    case 'db_password':
                        $result[$key]['is_ok'] = $exception->getCode() !== self::MYSQL_ERROR_CREDENTIAL;
                        break;
                }
            }
        }

        return array_merge(parent::getResult(), $result);
    }
}
