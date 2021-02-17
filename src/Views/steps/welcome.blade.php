@php /** @var string $namespace */ @endphp
@php /** @var string[][] $policies */ @endphp
@php /** @var string $url_next */ @endphp

@extends($namespace . '::layouts.common')

@include($namespace . '::icons.preset')

@section('title', __($namespace . '::welcome.title', compact('name')))

@section('content')
    <section>
        <p class="pb-2 text-gray-800">
            {!! __($namespace . '::welcome.line1', compact('name')) !!}
        </p>
        <p class="pb-2 text-gray-800">
            {!! __($namespace . '::welcome.line2', compact('name', 'vendor', 'purpose')) !!}
        </p>
    </section>
    <section>
        <p class="pb-2 text-gray-800">
            {!! __($namespace . '::welcome.line3') !!}
        </p>
        <ul class="list-disc list-inside bg-stripes-white pt-2 pb-7 ml-5">
            @foreach($policies as $policy)
                <li>
                    <a href="{{ $policy['url'] }}" target="_blank" class="no-underline hover:underline text-blue-500">
                        {{ $policy['name_'.app()->getLocale()] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </section>
    <section>
        <p class="pb-3 text-gray-800">
            {!! __($namespace . '::welcome.line4', compact('name')) !!}
        </p>
        <p class="pb-4 text-gray-800">
            @lang($namespace . '::common.need_help')
            <a class="text-blue-500 hover:underline" href="{{ $help_url }}" target="_blank">
                @lang($namespace . '::common.to_help_center')
            </a>.
        </p>
    </section>
    <div class="flex justify-end">
        <a href="{{ $url_next }}"
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
            @lang($namespace . '::common.start_install')
            @yield('icon_next_step')
        </a>
    </div>
@endsection
