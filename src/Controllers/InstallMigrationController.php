<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use function in_array;

/**
 * @package NobiDev\AppInstaller\Controllers
 */
class InstallMigrationController extends InstallController
{
    protected ?int $code = null;
    protected ?string $result = null;

    public function getContextData(Request $request): array
    {
        $result = [
            'migration' => [
                'value' => $this->result,
                'is_ok' => $this->code === 0,
            ]
        ];
        $auto_confirm = strtoupper($request->method()) === 'GET';
        $allow_next = !in_array(false, array_column($result, 'is_ok'), true);

        return array_merge(
            parent::getContextData($request),
            compact('result', 'auto_confirm', 'allow_next'),
        );
    }

    protected function setState(array $data): void
    {
        parent::setState($data);
        $this->code = Artisan::call('migrate');
        $this->result = Artisan::output();
    }

    protected function getView(): ?string
    {
        return 'steps.migration';
    }

    protected function getRouteNext(): ?string
    {
        return 'system';
    }
}
