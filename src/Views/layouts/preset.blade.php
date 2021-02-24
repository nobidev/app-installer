@php /** @var string $namespace */ @endphp
@php /** @var string $name */ @endphp
@php /** @var string $title */ @endphp
@php /** @var string $icon */ @endphp

@section('header')
    <div class="flex justify-center items-center">
        <img alt="{{ $name }}" src="{{ $icon }}" class="h-12"/>
        <h2 class="pl-6 uppercase font-medium text-2xl text-gray-800">
            {{ $title }}
        </h2>
    </div>
@stop
