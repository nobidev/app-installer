<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use JsonException;
use function extension_loaded;

/**
 * @package NobiDev\AppInstaller\Helpers
 */
class ServerHelper extends Helper
{
    protected static function checkExtensions(bool $development = false): array
    {
        $extensions = [];
        foreach (self::resolveConfigArray('extensions') as $extension) {
            $extensions[$extension] = extension_loaded($extension);
        }
        $composer_lock = PathHelper::findRootPath() . '/composer.lock';
        if (File::exists($composer_lock)) {
            try {
                $composer_data = json_decode(File::get($composer_lock), true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException $exception) {
                Log::error($exception->getMessage());
                return [];
            }
            $dependencies = [];
            foreach ($composer_data['packages'] as $package) {
                $dependencies[] = $package['name'];
                if (isset($package['require'])) {
                    array_push($dependencies, ...array_keys($package['require']));
                }
                if ($development && isset($package['require-dev'])) {
                    array_push($dependencies, ...array_keys($package['require-dev']));
                }
            }
            foreach (array_unique($dependencies) as $dependency) {
                if (strncmp($dependency, 'ext-', 4) === 0) {
                    $extension = substr($dependency, 4);
                    if ($extension !== false) {
                        $extensions[$extension] = extension_loaded($extension);
                    }
                }
            }
        }
        return $extensions;
    }

    public static function getResult(): array
    {
        $os = PHP_OS;
        $os_required = self::resolveConfig('server.os');

        $sapi = PHP_SAPI;
        $sapi_required = self::resolveConfig('server.sapi');

        $php_version = PHP_VERSION;
        $php_version_required = self::resolveConfig('server.php_version');

        $result = [
            'os' => [
                'value' => $os,
                'is_ok' => $os === $os_required,
            ],
            'sapi' => [
                'value' => $sapi,
                'is_ok' => $sapi === $sapi_required,
            ],
            'php_version' => [
                'value' => $php_version,
                'is_ok' => version_compare($php_version, $php_version_required, '>'),
            ],
        ];

        foreach (self::checkExtensions() as $extension => $is_ok) {
            $value = phpversion($extension);
            $result[sprintf('extension_%s', $extension)] = array_merge(
                compact('extension', 'value', 'is_ok'), [
                'label' => 'extension',
            ],
            );
        }

        return array_merge(parent::getResult(), $result);
    }
}
