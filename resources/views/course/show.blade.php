@extends('layout.app')

@section('title', $course->name)

@section('content')
<div class="container">
  <div class="row">
    <div class="col-12">
      <img class="img-fluid" src="{{ $course->banner }}" alt="{{ $course->name }}">
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="intro">{!! $course->introduction !!}</div>
      <div class="extra">
        <a class="btn btn-primary btn-w-150" href="{{ route('course.chapters', $course) }}">
          @if ()
        </a>
      </div>
    </div>
  </div>
</div>

<div class="row course-detail">
    <div class="col-md-12 head">
        <img src="{{ $course->banner }}" alt="{{ $course->name }}" width="100%">
    </div>
    <div class="col-md-12 body">
        <dl class="intro">
            {!! $course->introduction !!}
        </dl>
        <div class="extra">
            <a href="{{ route('course.chapters', $course) }}" class="btn btn-primary btn-wider-look">
                @if ( !Auth::check() || (Auth::check() && !Auth::user()->subscribed($course)) )
                    免费试读
                @else
                    开始阅读
                @endif
            </a>
            @if ( !Auth::check() || (Auth::check() && !Auth::user()->subscribed($course)) )
                <a href="{{ route('course.purchase', $course) }}" class="btn btn-primary btn-wider-look">订阅 ￥{{ $course->getPriceForHumans() }}</a>
            @endif
        </div>
    </div>
</div>
@endsection