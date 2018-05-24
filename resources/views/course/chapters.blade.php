@extends('layouts.app')

@section('title', $course->name)

@section('content')
  @component('components.card')
    <div class="row p-md-2">
      <div class="col-md-8"><h1>{{ $course->name }}</h1></div>
      <div class="col-md-4"><div class="author">野得出品</div></div>
      @if (!optional(Auth::user())->isSubscriberOf($course))
        <div class="col-12">
          <div class="extra">
            <a href="{{ route('course.purchase', $course) }}" class="btn btn-primary btn-w-150">订阅 ￥{{ $course->getPriceForHumans() }}</a>
          </div>
        </div>
      @endif
      <div class="col-12">
        <dl class="chapters">
          @foreach ($chapters as $chapter)
            <dt>{{ $chapter->name }}</dt>
            @foreach ($chapter->topics as $topic)
              <dd>
                {{-- Subscriber --}}
                @if ($canshow)
                  <a href="{{ $topic->link($course->slug) }}">{{ $topic->title }}</a>
                {{-- Guest --}}
                @else
                  @if ($topic->is_free)
                    {{-- Free topic--}}
                    <a href="{{ $topic->link($course->slug) }}"><span class="badge badge-primary">免费试读</span>{{ $topic->title . '-' . $topic->course_id }}</a>
                  @else
                    <span>{{ $topic->title }}</span>
                  @endif

                  @if (!$topic->is_free)
                    <span class="float-right"><i class="anticon icon-lock"></i></span>
                  @endif
                @endif
              </dd>
            @endforeach
          @endforeach
        </dl>
      </div>
    </div>
  @endcomponent
@endsection