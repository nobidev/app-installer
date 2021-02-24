<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Helpers;

use NobiDev\AppInstaller\Constant;
use function call_user_func;

/**
 * @package NobiDev\AppInstaller\Helpers
 */
class OwnerHelper extends Helper
{
    public static function getConfigMapping(): array
    {
        return array_merge(parent::getConfigMapping(), [
            'name' => self::getConfigKey('name'),
            'username' => self::getConfigKey('username'),
            'password' => self::getConfigKey('password'),
            'email' => self::getConfigKey('email'),
        ]);
    }

    protected static function getConfigKey(string $key): string
    {
        return sprintf('%s.user.%s', Constant::getName(), $key);
    }

    public static function getValue(): array
    {
        $result = parent::getValue();
        foreach (['name', 'username', 'password', 'email'] as $key) {
            $value = old($key);
            if ($value) {
                $result[$key] = $value;
            }
        }
        return array_merge(parent::getValue(), $result);
    }

    public static function setRuntime(array $data): void
    {
        parent::setRuntime($data);
        $model_type = config(self::getConfigKey('model_type'));
        /** @noinspection VariableFunctionsUsageInspection */
        /** @noinspection PhpUndefinedCallbackInspection */
        call_user_func([$model_type, 'createOwnerAccount'], $data);
    }
}
