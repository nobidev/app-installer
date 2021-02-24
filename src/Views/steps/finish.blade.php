@php /** @var string $namespace */ @endphp
@php /** @var int $second */ @endphp
@php /** @var string $url_next */ @endphp

@extends($namespace . '::layouts.common')

@include($namespace . '::icons.preset')

@section('title', __($namespace . '::finish.title'))

@section('content')
    <p class="pb-2 text-gray-800">
        {!! __($namespace . '::finish.line1', compact('name', 'second')) !!}
    </p>
    <div class="flex justify-end">
        <a href="{{ $url_next }}"
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
            @lang($namespace . '::common.end_install')
            @yield('icon_next_step')
        </a>
    </div>
    @if(isset($second))
        <script>
            window.addEventListener('load', () => {
                const second = @json($second, JSON_THROW_ON_ERROR);
                setTimeout(() => {
                    window.location.href = '{{ $url_next }}';
                }, second * 1000);
            });
        </script>
    @endif
@endsection
