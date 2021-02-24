@php /** @var string $namespace */ @endphp

@extends($namespace . '::layouts.base')

@include($namespace . '::layouts.head')

@include($namespace . '::layouts.preset')

@section('body')
    <main class="h-screen w-screen">
        <div class="flex h-screen py-6">
            <div class="container m-auto">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-8 border-b border-gray-200 sm:px-6">
                        @yield('header')
                    </div>
                    <div class="px-4 py-5 sm:px-6">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
