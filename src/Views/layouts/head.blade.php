@php /** @var string $namespace */ @endphp
@php /** @var string $title */ @endphp
@php /** @var string $favicon */ @endphp
@php /** @var string $cover */ @endphp


@section('title')
    @yield('page_title') - {{ $title }}
@stop
@section('favicon', $favicon)

@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: url("{{ $cover  }}") fixed;
        }
    </style>
@stop
