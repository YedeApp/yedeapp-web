@extends('layouts.app')

@section('title', '首页')

@section('content')
  @foreach ($courses as $course)
    @component('components.card')
      <div class="row">
        <div class="col-md-3">
          <a class="cover mt-4 mt-sm-0" href="{{ route('course.show', $course) }}"><img class="img-fluid img-shadow" src="{{ $course->cover }}"></a>
        </div>
        <div class="col-md-9">
          <div class="name mt-4 mt-sm-0">{{ $course->name }}</div>
          <div class="intro">
            <p>{{ $course->intro }}</p>
          </div>
          <div class="extra">
            @if (optional(Auth::user())->isSubscriberOf($course))
              <a href="{{ route('course.chapters', $course) }}" class="btn btn-primary btn-w-150">开始阅读</a>
            @else
              <a href="{{ route('course.show', $course) }}" class="btn btn-primary btn-w-150">了解更多</a>
            @endif
          </div>
        </div>
      </div>
    @endcomponent
  @endforeach
@endsection