@extends('layouts.app')

@section('title', $course->name)

@section('content')
<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-8"><h1>{{ $course->name }}</h1></div>
            <div class="col-md-4"><div class="author">野得APP出品</div></div>
            <div class="col-12">
              <div class="intro">{!! $course->introduction !!}</div>
              <div class="extra">
                <a class="btn btn-primary btn-w-120" href="{{ route('course.chapters', $course) }}">
                  开始阅读
                </a>
                <a href="{{ route('course.purchase', $course) }}" class="btn btn-primary btn-w-120 ml-2">订阅 ￥{{ $course->getPriceForHumans() }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{--  <div class="row course-detail">
    <div class="col-md-12 head">
        <img src="{{ $course->banner }}" alt="{{ $course->name }}" width="100%">
    </div>
    <div class="col-md-12 body">
        <dl class="intro">
            {!! $course->introduction !!}
        </dl>
        <div class="extra">
            <a href="{{ route('course.chapters', $course) }}" class="btn btn-primary btn-wider-look">
                @if ( !Auth::check() || (Auth::check() && !Auth::user()->isSubscriberOf($course)) )
                    免费试读
                @else
                    开始阅读
                @endif
            </a>
            @if ( !Auth::check() || (Auth::check() && !Auth::user()->isSubscriberOf($course)) )
                <a href="{{ route('course.purchase', $course) }}" class="btn btn-primary btn-wider-look">订阅 ￥{{ $course->getPriceForHumans() }}</a>
            @endif
        </div>
    </div>
</div>  --}}
@endsection