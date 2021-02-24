<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use Exception;
use Illuminate\Http\Request;
use NobiDev\AppInstaller\Helpers\OwnerHelper;
use function in_array;

/**
 * @package NobiDev\AppInstaller\Controllers
 */
class InstallOwnerController extends InstallController
{
    protected ?string $value = null;
    protected bool $is_ok = false;

    protected function setState(array $data): void
    {
        parent::setState($data);
        try {
            OwnerHelper::setRuntime($data);
            $this->is_ok = true;
        } catch (Exception $error) {
            $this->value = $error->getMessage();
        }
    }

    public function getContextData(Request $request): array
    {
        $result = OwnerHelper::getResult();
        $result['result'] = [
            'value' => $this->value,
            'is_ok' => $this->is_ok
        ];
        $allow_next = !in_array(false, array_column($result, 'is_ok'), true);

        return array_merge(
            parent::getContextData($request),
            compact('result', 'allow_next'),
        );
    }

    protected function getView(): ?string
    {
        return 'steps.owner';
    }

    protected function getRouteNext(): ?string
    {
        return 'seed';
    }
}
