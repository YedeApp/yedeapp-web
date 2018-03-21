@extends('layouts.app')

@section('title', $course->name)

@section('content')
  @component('components.card')
    <div class="chapters">
      @isset($chapters)
        <dl>
          @foreach ($chapters as $chapter)
            <dt>{{ $chapter->name }}</dt>
            {{--  @foreach ($chapter->topics as $topic)
              <dd>{{ $topic->title }}</dd>
            @endforeach  --}}
          @endforeach
        </dl>
      @endisset
    </div>
  @endcomponent
@endsection