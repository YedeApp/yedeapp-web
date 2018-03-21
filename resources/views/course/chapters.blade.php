@extends('layouts.app')

@section('title', $course->name)

@section('content')
  @component('components.card')
    <div class="row p-md-2">
      <div class="col-md-8"><h1>{{ $course->name }}</h1></div>
      <div class="col-md-4"><div class="author">野得出品</div></div>
      <div class="col-12">
        <div class="extra">
          <a href="{{ route('course.purchase', $course) }}" class="btn btn-primary btn-w-120 ml-2">订阅 ￥{{ $course->getPriceForHumans() }}</a>
        </div>
      </div>
      <div class="col-12">
        <dl class="chapters">
          @foreach ($chapters as $chapter)
            <dt>{{ $chapter->name }}</dt>
            @foreach ($chapter->topics as $topic)
              <dd>{{ $topic->title }}</dd>
            @endforeach
          @endforeach
        </dl>
      </div>
    </div>
  @endcomponent
@endsection