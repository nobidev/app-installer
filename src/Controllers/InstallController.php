<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use NobiDev\AppInstaller\Constant;
use NobiDev\AppInstaller\Helpers\Helper;
use Symfony\Component\HttpFoundation\Response as BaseResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @package NobiDev\AppInstaller\Controllers
 */
abstract class InstallController extends Controller
{
    protected string $routePrefix = 'install';

    public function index(Request $request): BaseResponse
    {
        $view_path = $this->getView();
        if (!$view_path) {
            throw new NotFoundHttpException();
        }

        $context_data = $this->getContextData($request);

        if (
            isset($context_data['url_next'], $context_data['allow_next'])
            && $context_data['allow_next']
            && $request->get('auto_next')
        ) {
            return redirect($context_data['url_next']);
        }

        return Response::view(Helper::withNamespace($view_path), $context_data);
    }

    protected function setState(array $data): void
    {
    }

    public function submit(Request $request): BaseResponse
    {
        $this->setState($request->all());
        return $this->index($request);
    }

    abstract protected function getView(): ?string;

    public function getContextData(Request $request): array
    {
        $namespace = Constant::getName();
        $icon = Helper::resolveConfig('icon');
        $favicon = Helper::resolveConfig('favicon');
        $cover = Helper::resolveConfig('cover');
        $name = __(Helper::resolveConfig('name'));
        $title = __(Helper::resolveConfig('title'), ['name' => $name]);
        $vendor = Helper::resolveConfig('vendor');
        $url_retry = $request->fullUrlWithQuery(['retry' => 1 + $request->get('retry', 0)]);

        $context_data = compact(
            'namespace', 'icon', 'favicon', 'cover', 'name',
            'title', 'vendor', 'url_retry',
        );

        $url_next = $this->getUrlNext();
        if ($url_next) {
            $context_data['url_next'] = $url_next;
        }

        return $context_data;
    }

    protected function getUrlNext(array $parameters = []): ?string
    {
        $route_next = $this->getRouteNext();
        if (!$route_next) {
            return null;
        }
        return route(
            $this->resolveRoute($route_next),
            array_merge(['auto_next' => !config('app.debug')], $parameters),
        );
    }

    abstract protected function getRouteNext(): ?string;

    protected function resolveRoute(string $name): string
    {
        return Helper::withNamespace(sprintf('%s.%s', $this->routePrefix, $name));
    }
}
