@extends('layouts.app')

@section('title', $course->name)

@section('content')
  @component('components.card')
    <div class="row p-md-2">
      <div class="col-md-8"><h1>{{ $course->name }}</h1></div>
      <div class="col-md-4"><div class="author">野得出品</div></div>
      <div class="col-12">
        <div class="extra">
          <a href="{{ route('course.purchase', $course) }}" class="btn btn-primary btn-w-150">订阅 ￥{{ $course->getPriceForHumans() }}</a>
        </div>
      </div>
      <div class="col-12">
        <dl class="chapters">
          @foreach ($chapters as $chapter)
            <dt>{{ $chapter->name }}</dt>
            @foreach ($chapter->topics as $topic)
              <dd>
                {{-- Subscriber --}}
                @can('show', $course)
                  <a href="{{ route('topic.show', $topic->id) }}">{{ $topic->title }}</a>
                {{-- Guest --}}
                @else
                  @if($topic->is_free)
                    {{-- Free topic--}}
                    <a href="{{ route('topic.show', $topic->id) }}"><span class="badge badge-primary">免费试读</span>{{ $topic->title . '-' . $topic->course_id }}</a>
                  @else
                    <span>{{ $topic->title }}</span>
                  @endif

                  @if(!$topic->is_free)
                    <span class="pull-right"><svg class="icon" aria-hidden="true" title="订阅后开启"><use xlink:href="#icon-lock"></use></svg></span>
                  @endif
                @endcan
              </dd>
            @endforeach
          @endforeach
        </dl>
      </div>
    </div>
  @endcomponent
@endsection