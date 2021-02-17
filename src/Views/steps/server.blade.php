@php /** @var string $namespace */ @endphp
@php /** @var string[][] $result */ @endphp
@php /** @var bool $allow_next */ @endphp
@php /** @var string $url_next */ @endphp
@php /** @var string $url_retry */ @endphp

@extends($namespace . '::layouts.common')

@include($namespace . '::icons.preset')

@section('page_title', __($namespace . '::server.title'))

@section('content')
    <p class="pb-3 text-gray-800">@lang($namespace . '::server.introduce')</p>
    <div class="flex flex-wrap border border-gray-200 text-gray-800 rounded-md mb-4">
        @foreach($result as $key => $item)
            <div class="w-full px-4 py-2 border-b border-gray-200 text-gray-800">
                @if(isset($item['label']))
                    @lang($namespace . '::server.' . $item['label'], $item)
                @else
                    @lang($namespace . '::server.' . $key)
                @endif
                @if(isset($item['is_ok']))
                    <span class="float-right">
                    @if($item['is_ok'])
                            @yield('icon_check_success')
                        @else
                            @yield('icon_check_failed')
                        @endif
                </span>
                @endif
                @if(isset($item['value']))
                    <span class="float-right mr-3">
                        {{ $item['value'] }}
                    </span>
                @endif
            </div>
        @endforeach
    </div>
    <div class="flex justify-end">
        @if($allow_next)
            <a href="{{ $url_next }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                @lang($namespace . '::common.next_step')
                @yield('icon_next_step')
            </a>
        @else
            <a href="{{ $url_retry }}"
               class="bg-red-600 hover:bg-red-500 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                @lang($namespace . '::common.retry')
                @yield('icon_retry')
            </a>
        @endif
    </div>
@endsection
