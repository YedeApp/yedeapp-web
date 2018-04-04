<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- CSRF --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'YedeApp') - 野得APP</title>

  {{-- Styles --}}
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @yield('styles')
</head>
<body>
  <div id="app" class="{{ getRouteCls() }}-page">

    @include('layouts._header')

    <div class="container">
      @yield('content')
    </div>

    @include('layouts._footer')
  </div>

  {{-- Temporary debug tool Sudosu --}}
  @if (app()->isLocal())
    @include('sudosu::user-selector')
  @endif

  {{-- Scripts --}}
  <script src="{{ asset('js/app.js') }}"></script>
  @yield('scripts')
  <script src="{{ asset('js/iconfont.js') }}"></script>
</body>
</html>