@extends('layouts.app')

@section('title', $user->name . ' 的个人资料')

@section('content')
  @component('components.card')
    <div class="row ">
      <div class="col-md-3 text-center">
        <img id="avatar-image" src="{{ $user->avatar }}" alt="{{ $user->name }}" class="img-thumbnail img-avatar" width="188">
      </div>
      <div class="col-md-7 align-self-end">
        <div class="name">{{ $user->name }}</div>
        <div class="intro">{{ $user->introduction }}</div>
      </div>
      @can('update', $user)
      <div class="col-md-2 align-self-end text-right">
        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-outline-primary">编辑个人资料</a>
      </div>
      @endcan
    </div>
  @endcomponent

  @component('components.card')
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link {{ active_class( if_route('user.show') && (if_route_param('tab', '') || if_route_param('tab', 'activities')) ) }}" href="{{ route('user.show', [$user, 'activities']) }}">动态</a>
        <a class="nav-item nav-link {{ active_class( if_route('user.show') && if_route_param('tab', 'comments') ) }}" href="{{ route('user.show', [$user, 'comments']) }}">留言</a>
      </div>
    </nav>
    <div class="tab-content">
      {{-- 动态 --}}
      <div class="tab-pane show active" role="tabpanel">
        @include('user._' . $tab)
      </div>
    </div>
  @endcomponent
@endsection