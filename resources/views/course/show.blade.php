@extends('layouts.app')

@section('title', $course->name)

@section('content')
  @component('components.card')
    <div class="row p-md-2">
      <div class="col-md-8"><h1>{{ $course->name }}</h1></div>
      <div class="col-md-4"><div class="author">野得出品</div></div>
      <div class="col-12">
        <div class="intro">{!! $course->introduction !!}</div>
        <div class="extra">
          <a href="{{ route('course.chapters', $course) }}" class="btn btn-primary btn-w-120">
            @if (optional(Auth::user())->isSubscriberOf($course))
              开始阅读
            @else
              免费试读
            @endif
          </a>
          @if (!optional(Auth::user())->isSubscriberOf($course))
            <a href="{{ route('course.purchase', $course) }}" class="btn btn-primary btn-w-120 ml-2">订阅 ￥{{ $course->getPriceForHumans() }}</a>
          @endif
        </div>
      </div>
    </div>
  @endcomponent
@endsection