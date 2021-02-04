<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Contracts;

use Illuminate\Contracts\Container\Container;

/**
 * @package NobiDev\AppInstaller\Contracts
 */
interface AppInstaller
{
    public function __construct(Container $app);

    public function load(): AppInstaller;

    /**
     * @noinspection PhpMethodNamingConventionInspection
     */
    public function getInstalledLockPath(): string;

    public function alreadyInstalled(): bool;

    public function setAsNoInstalled(): void;

    public function setAsInstalled(): void;
}
