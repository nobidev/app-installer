<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\File;
use JsonException;
use NobiDev\AppInstaller\Contracts\AppInstaller as AppInstallerContract;
use NobiDev\AppInstaller\Exceptions\ApplicationInvalidException;

/**
 * @package NobiDev\AppInstaller
 */
class AppInstaller implements AppInstallerContract
{
    protected Container $application;

    /**
     * @param Container $app
     * @throws ApplicationInvalidException
     */
    public function __construct(Container $app)
    {
        $this->application = $app;

        $this->load();
    }

    /**
     * @return $this
     * @throws ApplicationInvalidException
     */
    public function load(): AppInstaller
    {
        if ($this->application !== app()) {
            throw new ApplicationInvalidException('AppInstaller must be installed on the main context of Laravel.');
        }

        return $this;
    }

    public function alreadyInstalled(): bool
    {
        return File::exists($this->getInstalledLockPath());
    }

    /**
     * @noinspection PhpMethodNamingConventionInspection
     */
    public function getInstalledLockPath(): string
    {
        return storage_path('installed');
    }

    public function setAsNoInstalled(): void
    {
        File::delete($this->getInstalledLockPath());
    }

    /**
     * @throws JsonException
     */
    public function setAsInstalled(): void
    {
        $content = json_encode([
            'date' => date('Y/m/d h:i:s')
        ], JSON_THROW_ON_ERROR);
        File::put($this->getInstalledLockPath(), $content, true);
    }
}
