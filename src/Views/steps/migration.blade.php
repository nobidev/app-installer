@php /** @var string $namespace */ @endphp
@php /** @var string[][] $result */ @endphp
@php /** @var bool $auto_confirm */ @endphp
@php /** @var string $url_next */ @endphp
@php /** @var string $url_retry */ @endphp

@extends($namespace . '::layouts.common')

@include($namespace . '::icons.preset')

@section('page_title', __($namespace . '::migration.title'))

@section('content')
    <p class="pb-3 text-gray-800">@lang($namespace . '::migration.introduce')</p>
    <form method="POST" action="{{ $url_retry }}">
        @csrf
        @if($result['migrate']['value'])
            <div class="flex">
                <pre class="border-2 p-3 m-5 w-full text-xs">{{ $result['migrate']['value'] }}</pre>
            </div>
        @endif
        <div class="flex justify-end">
            @if($allow_next)
                <a href="{{ $url_next }}"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    @lang($namespace . '::common.next_step')
                    @yield('icon_next_step')
                </a>
            @else
                @if($auto_confirm)
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                        @lang($namespace . '::common.confirm')
                        @yield('icon_retry')
                    </button>
                @else
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-500 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                        @lang($namespace . '::common.retry')
                        @yield('icon_retry')
                    </button>
                @endif
            @endif
        </div>
    </form>
    @if($auto_confirm)
        <script>
            window.addEventListener('load', () => {
                setTimeout(() => {
                    const form = document.querySelector('main form');
                    if (form) {
                        form.submit();
                    }
                }, 1000);
            });
        </script>
    @endif
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
