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
  {{-- No support for IE which version less than 10 --}}
  <!--[if lt IE 10]>
  <div class="alert alert-warning alert-dismissible fade show m-0 rounded-0" role="alert">
    您目前使用的 IE 浏览器版本过于陈旧。请使用现代的浏览器以获得最佳的浏览效果。
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <![endif]-->

  <div id="app" class="{{ getRouteCls() }}-page">

    @include('layouts._header')

    <div class="container">
      {{-- Messages --}}
      <div class="text-center">
        @include('layouts._messages')
      </div>

      {{-- Content --}}
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