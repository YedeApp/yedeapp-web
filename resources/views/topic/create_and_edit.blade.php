@extends('layouts.app')

@section('title', $topic->id ? '编辑 ' . $topic->title : '新建文章')

@section('content')
  @component('components.card')

    {{-- Head --}}
    <div class="head">
      <i class="anticon icon-form"></i>
      @if($topic->id)
        编辑文章
      @else
        新建文章
      @endif
    </div>

    {{-- Error area --}}
    @include('components.error')

    {{-- Body and form --}}
    <div class="body">
      @if($topic->id)
        <form action="{{ route('topic.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
          {{ method_field('PUT') }}
      @else
        <form action="{{ route('topic.store') }}" method="POST" accept-charset="UTF-8">
      @endif

      {{ csrf_field() }}

      <div class="form-group row">
        <label for="title" class="col-12 col-form-label">标题</label>
        <div class="col-12">
          <input name="title" id="title" type="text" class="form-control" value="{{ old('title', $topic->title) }}" min-length="3" required>
        </div>
      </div>

      <div class="form-group row">
        <label for="content" class="col-12 col-form-label">内容</label>
        <div class="col-12">
          <textarea name="content" id="content" class="form-control" rows="15" min-length="3" required>{{ old('content', $topic->content) }}</textarea>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-12 col-md-4 mb-3">
          <label for="courses" class="col-form-label">课程</label>
          <select name="course_id" id="courses" class="form-control" onchange="reloadChapters(this)" required>
            <option value="" hidden disabled {{ null === old('course_id', $topic->course_id) ? 'selected' : '' }}>请选择课程</option>
            @foreach ($courses as $course)
              <option value="{{ $course->id }}" data="{{ $course->chapters }}">{{ $course->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-12 col-md-4 mb-3">
          <label for="chapters" class="col-form-label">章节</label>
          <select name="chapter_id" id="chapters" class="form-control" required>
            <option value="" hidden disabled {{ null === old('chapter_id', $topic->chapter_id) ? 'selected' : '' }}>请选择章节</option>
          </select>
        </div>

        <div class="col-12 col-md-2 mb-3">
          <label for="is_free" class="col-form-label">免费</label>
          <select name="is_free" id="is_free" class="form-control" required>
            <option value="1" {{ 1 == old('free', $topic->is_free) ? 'selected' : '' }}>是</option>
            <option value="0" {{ 0 == old('free', $topic->is_free) ? 'selected' : '' }}>否</option>
          </select>
        </div>

        <div class="col-12 col-md-2 mb-3">
          <label for="active" class="col-form-label">发布</label>
          <select name="active" id="active" class="form-control" required>
            <option value="1" {{ 1 == old('active', $topic->active) ? 'selected' : '' }}>是</option>
            <option value="0" {{ 0 == old('active', $topic->active) ? 'selected' : '' }}>否</option>
          </select>
          </div>
      </div>

      <div class="form-group row">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-w-100 mr-2">确定</button>
          {{-- <a href="{{ $topic->link() }}" role="button" class="btn btn-secondary btn-w-100">返回</a> --}}
        </div>
      </div>

      </form>
    </div>
  @endcomponent
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/mditor.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/fontawesome.min.css') }}">
@endsection

@section('scripts')
<script>
var $courses = $('#courses');
var $chapters = $('#chapters');

function initControls() {
  var courseId = '{{ old('course_id', $topic->course_id) }}';
  var chapterId = '{{ old('chapter_id', $topic->chapter_id) }}';

  initCoursesControl(courseId);
  initChaptersControl(chapterId);
}

function initCoursesControl(courseId) {
  if (courseId) {
    $courses.val(courseId);
  }
}

function initChaptersControl(chapterId) {
  reloadChapters($courses);
  if (chapterId) {
    $chapters.val(chapterId);
  }
}

function reloadChapters(selector) {
  var data = $(selector).find('option:selected').attr('data');
  if (data) {
    var chapters = JSON.parse(data);

    $chapters.children('option').remove();

    for (var i = 0; i < chapters.length; i++) {
        var chapter = chapters[i];
        $option = $('<option value="' + chapter.id + '">' + chapter.name + '</option>');
        $chapters.append($option);
    }
  }
}

initControls();

// Init Mditor
$(document).ready(function() {
    var mditor =  Mditor.fromTextarea(document.getElementById('content'));
})
</script>

{{-- Import mditor --}}
<script type="text/javascript"  src="{{ asset('js/mditor.min.js') }}"></script>
@endsection