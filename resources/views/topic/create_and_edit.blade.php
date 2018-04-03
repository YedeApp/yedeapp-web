@extends('layouts.app')

@section('title', $topic->title ? '编辑 ' . $topic->title : '新建文章')

@section('content')
<div class="row">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h4>
                <svg class="icon" aria-hidden="true" title="编辑"><use xlink:href="#icon-edit"></use></svg>
                @if($topic->id)
                    编辑文章
                @else
                    新建文章
                @endif
            </h4>
        </div>
        @include('common.error')

        <div class="panel-body">
            @if($topic->id)
                <form action="{{ route('topic.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="{{ route('topic.store') }}" method="POST" accept-charset="UTF-8">
            @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label>标题</label>
                    <input class="form-control" type="text" name="title" id="title_field" value="{{ old('title', $topic->title) }}" required />
                </div>
                <div class="form-group">
                    <label>正文</label>
                    <textarea class="form-control" name="body" id="editor" rows="10" required>{{ old('body', $topic->body) }}</textarea>
                </div>
                <div class="form-group">
                    <label>课程</label>
                    <select id="courses_field" class="form-control" name="course_id" onchange="reloadChapters(this)" required>
                        <option value="" hidden disabled {{ null === old('course_id', $topic->course_id) ? 'selected' : '' }}>请选择课程</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" data="{{ $course->chapters }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>章节</label>
                    <select id="chapters_field" class="form-control" name="chapter_id" required>
                        <option value="" hidden disabled {{ null === old('chapter_id', $topic->chapter_id) ? 'selected' : '' }}>请选择章节</option>
                    </select>
                </div>
                <div class="form-group">
                        <label>免费</label>
                        <select class="form-control" name="free" required>
                            <option value="1" {{ 1 == old('free', $topic->free) ? 'selected' : '' }}>是</option>
                            <option value="0" {{ 0 == old('free', $topic->free) ? 'selected' : '' }}>否</option>
                        </select>
                    </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-wider-look">确定</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/mditor.min.css') }}">
@endsection

@section('scripts')
<script type="text/javascript"  src="{{ asset('js/mditor.min.js') }}"></script>
<script>
var $courses = $('#courses_field');
var $chapters = $('#chapters_field');

function initControls() {
    var courseId = '{{ old('course_id', $topic->course_id) }}';
    var chapterId = '{{ old('course_id', $topic->chapter_id) }}';

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
        // Init options when reload
        $chapters.children('option').remove();

        for (var i = 0; i < chapters.length; i++) {
            var chapter = chapters[i];
            $option = $('<option value="' + chapter.id + '">' + chapter.name + '</option>');
            $chapters.append($option);
        }
    }
}

initControls();

$(document).ready(function(){
    var mditor =  Mditor.fromTextarea(document.getElementById('editor'));
})
</script>
@endsection