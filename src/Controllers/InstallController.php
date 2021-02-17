<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use NobiDev\AppInstaller\Constant;
use Symfony\Component\HttpFoundation\Response as BaseResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @package NobiDev\AppInstaller\Controllers
 */
abstract class InstallController extends Controller
{
    protected string $routePrefix = 'install';

    public function index(): BaseResponse
    {
        $view_path = $this->getView();
        if (!$view_path) {
            throw new NotFoundHttpException();
        }
        return Response::view($this->withNamespace($view_path), $this->getContextData());
    }

    abstract protected function getView(): ?string;

    public function getContextData(): array
    {
        $namespace = Constant::getName();
        $icon = $this->resolveConfig('icon');
        $favicon = $this->resolveConfig('favicon');
        $cover = $this->resolveConfig('cover');
        $name = __($this->resolveConfig('name'));
        $title = __($this->resolveConfig('title'), ['name' => $name]);
        $vendor = $this->resolveConfig('vendor');

        $context_data = compact('namespace', 'icon', 'favicon', 'cover', 'name', 'title', 'vendor');

        $url_next = $this->getUrlNext();
        if ($url_next) {
            $context_data['url_next'] = $url_next;
        }

        return $context_data;
    }

    protected function resolveConfig(string $name, string $default = ''): string
    {
        return config($this->withNamespace($name, '.'), $default);
    }

    protected function getUrlNext(array $parameters = []): ?string
    {
        $route_next = $this->getRouteNext();
        if (!$route_next) {
            return null;
        }
        return route(
            $this->resolveRoute($route_next),
            array_merge(['auto_next' => true], $parameters),
        );
    }

    abstract protected function getRouteNext(): ?string;

    protected function resolveRoute(string $name): string
    {
        return $this->withNamespace(sprintf('%s.%s', $this->routePrefix, $name));
    }

    protected function resolveConfigArray(string $name, array $default = []): array
    {
        return config($this->withNamespace($name, '.'), $default);
    }

    protected function withNamespace(string $name, string $separator = '::'): string
    {
        return sprintf('%s%s%s', Constant::getName(), $separator, $name);
    }
}
