<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Installation - {{ config('app.name', 'Laravel') }}</title>
    <!--suppress HtmlUnknownTarget -->
    <link rel="shortcut icon" href="/images/common/shortcut-icon.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css" rel="stylesheet">
</head>
<body>

<!--suppress CssUnknownTarget -->
<div class="h-screen w-screen bg-cover bg-no-repeat bg-center"
     style="background-image: url('/images/installer/cover.png');">
    <div class="flex h-screen py-6">
        <div class="container m-auto">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-8 border-b border-gray-200 sm:px-6">
                    <div class="flex justify-center items-center">
                        <!--suppress HtmlUnknownTarget -->
                        <img alt="App logo" class="h-12" src="/images/common/app-icon.png">
                        <h2 class="pl-6 uppercase font-medium text-2xl text-gray-800">
                            {{ config('app.name', 'Application') }} Installation
                        </h2>
                    </div>
                </div>
                <div class="px-4 py-5 sm:px-6">
                    @yield('step')
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
