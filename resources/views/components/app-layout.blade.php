<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Trufel') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="index" class="font-alice text-gray-600 flex flex-col">
  @if (Request::is('/'))
    @include('layouts.navigation-title')
  @else
    @include('layouts.navigation-general')
  @endif
  <main class="mb-auto mx-auto max-w-6xl">
   {{ $slot }}
  </main>
  @include('layouts.footer')
  @include('layouts.modal-order')
</body>

</html>