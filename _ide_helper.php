<?php
/*
 * Copyright (c) 2021 NobiDev
 */

/**
 * @noinspection UnknownInspectionInspection
 * @noinspection PhpMissingDocCommentInspection
 * @noinspection EmptyClassInspection
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpMethodNamingConventionInspection
 * @noinspection PhpClassNamingConventionInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller {
    class FacadeImplemented
    {
        protected static AppInstaller $instance;

        public static function load(): AppInstaller
        {
            return self::$instance->load();
        }

        public static function getInstalledLockPath(): string
        {
            return self::$instance->getInstalledLockPath();
        }

        public static function alreadyInstalled(): bool
        {
            return self::$instance->alreadyInstalled();
        }

        public static function setAsNoInstalled(): void
        {
            self::$instance->setAsNoInstalled();
        }

        public static function setAsInstalled(): void
        {
            self::$instance->setAsInstalled();
        }
    }
}

namespace {

    use NobiDev\AppInstaller\FacadeImplemented;

    class AppInstaller extends FacadeImplemented
    {
    }
}
