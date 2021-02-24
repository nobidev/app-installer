@php /** @var string $namespace */ @endphp
@php /** @var string[][] $result */ @endphp
@php /** @var bool $allow_next */ @endphp
@php /** @var string $url_next */ @endphp
@php /** @var string $url_retry */ @endphp

@extends($namespace . '::layouts.common')

@include($namespace . '::icons.preset')

@section('page_title', __($namespace . '::owner.title'))

@section('content')
    <p class="pb-3 text-gray-800">@lang($namespace . '::owner.introduce')</p>
    @if(!$result['result']['is_ok'] && $result['result']['value'])
        <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-3">
            <div class="flex">
                <div class="flex-shrink-0">@yield('icon_error')</div>
                <div class="ml-3">
                    <p class="text-sm leading-5 text-red-700">
                        {{ $result['result']['value'] }}
                    </p>
                </div>
            </div>
        </div>
    @endif
    <form method="POST" action="{{ $url_retry }}">
        @csrf
        @foreach(['name', 'username', 'password', 'email'] as $field)
            <div class="mb-3 p-3 rounded-lg {{ $result[$field]['is_ok'] ?: 'border border-red-500' }}">
                <label for="{{ $field }}" class="block font-medium leading-5 text-gray-700 pb-2">
                    @lang($namespace . '::owner.' . $field)
                </label>
                <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="{{ $field }}" name="{{ $field }}"
                       type="{{ strpos($field, 'password') === false ? 'text': 'password' }}"
                       placeholder="@lang($namespace . '::owner.' . $field)"
                       value="{{ $result[$field]['value'] }}"
                        {{ $allow_next ? 'disabled': '' }}
                />
            </div>
        @endforeach

        <div class="flex justify-end">
            @if($allow_next)
                <a href="{{ $url_next }}"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    @lang($namespace . '::common.next_step')
                    @yield('icon_next_step')
                </a>
            @else
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    @lang($namespace . '::common.confirm')
                    @yield('icon_retry')
                </button>
            @endif
        </div>
    </form>
    @if($allow_next)
        <script>
            window.addEventListener('load', () => {
                setTimeout(() => {
                    window.location.href = '{{ $url_next }}';
                }, 1000);
            });
        </script>
    @endif
@endsection
