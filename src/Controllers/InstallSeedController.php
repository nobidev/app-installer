<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response as BaseResponse;
use function in_array;

/**
 * @package NobiDev\AppInstaller\Controllers
 */
class InstallSeedController extends InstallController
{
    protected ?int $code = null;
    protected ?string $result = null;

    public function getContextData(Request $request): array
    {
        $result = [
            'seed' => [
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
        $this->code = Artisan::call('db:seed');
        $this->result = Artisan::output();
    }

    protected function getView(): ?string
    {
        return 'steps.seed';
    }

    protected function getRouteNext(): ?string
    {
        return 'finish';
    }

    public function index(Request $request): BaseResponse
    {
        if (config('app.is_demo')) {
            return parent::index($request);
        }
        return redirect($this->getUrlNext($request->query()));
    }
}
