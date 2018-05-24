@extends('layouts.app')

@section('title', config('app.name'))

@section('content')
  <div class="row">
    <div class="col-12">
      @component('components.card')
        {{-- Head --}}
        <div class="head">
          <i class="anticon icon-form"></i>
            @if($course->id)
              编辑课程
            @else
              新建课程
            @endif
        </div>

        {{-- Body and form --}}
        <div class="body">
          {{-- Show error --}}
          @include('components.error')

          @if ($course->id)
            <form id="course_form" action="{{ route('course.update', $course->slug) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
            {{ method_field('PUT') }}
          @else
            <form id="course_form" action="{{ route('course.store') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
          @endif

            {{ csrf_field() }}
            <div class="form-group row">
              <label for="name" class="col-md-2 col-form-label text-md-right">课程名</label>
              <div class="col-md-5">
                <input name="name" id="name" type="text" class="form-control {{ checkError($errors, 'name') }}" value="{{ old('name', $course->name) }}" min-length="2" required>
                {!! showErrorFeedback($errors, 'name') !!}
              </div>
              <div class="col-md-5 col-form-label tips">课程中文名，例如：一个入门教程</div>
            </div>

            <div class="form-group row">
              <label for="slug" class="col-md-2 col-form-label text-md-right">英文名</label>
              <div class="col-md-5">
                <input name="slug" id="slug" type="slug" class="form-control {{ checkError($errors, 'slug') }}" value="{{ old('slug', $course->slug) }}">
                {!! showErrorFeedback($errors, 'slug') !!}
              </div>
              <div class="col-md-5 col-form-label tips">可用连字符，不能用空格。例如：my-course</div>
            </div>

            <div class="form-group row">
              <label for="cover" class="col-md-2 col-form-label text-md-right">封面图</label>
              <div class="col-md-5"><input type="file" name="cover" id="cover" ></div>
              <div class="col-md-5 col-form-label tips">封面图片，尺寸：300 x 500</div>
            </div>

            @if($course->cover)
              <div class="form-group row">
                <div class="col-md-7 offset-md-2">
                  <label for="cover"><img class="img-fluid img-shadow" src="{{ $course->cover }}" width="200" /></label>
                </div>
              </div>
            @endif

            <div class="form-group row">
              <label for="price" class="col-md-2 col-form-label text-md-right">价格</label>
              <div class="col-md-2"><input class="form-control" type="text" name="price" id="price" value="{{ old('price', $course->price) }}" required /></div>
              <div class="col-md-5 offset-md-3 col-form-label tips">单位：分。例如：39.0 元，填写 3990</div>
            </div>

            <div class="form-group row">
              <label for="cover" class="col-md-2 col-form-label text-md-right">分章</label>
              <div class="col-md-5 clearfix chapters">
                <input type="hidden" id="chapters_hidden" name="chapters" value="{{ old('chapters', $course->chapters) }}" />
              </div>
              <div class="col-md-5 col-form-label tips">添加章节，填写每章标题</div>
            </div>

            <div class="form-group row">
              <label for="intro" class="col-md-2 col-form-label text-md-right">描述</label>
              <div class="col-md-7"><textarea name="intro" id="intro" class="form-control" rows="7" required>{{ old('intro', $course->intro) }}</textarea></div>
              <div class="col-md-3 col-form-label tips">用于首页和课程目录上方</div>
            </div>

            <div class="form-group row">
              <label for="introduction" class="col-md-2 col-form-label text-md-right">介绍</label>
              <div class="col-md-7"><textarea name="introduction" id="introduction" class="form-control" rows="15" required>{{ old('introduction', $course->introduction) }}</textarea></div>
              <div class="col-md-3 col-form-label tips">用于推广页面，详述课程亮点</div>
            </div>

            <div class="form-group row">
              <div class="col-md-5 offset-md-2">
                <button type="submit" class="btn btn-primary btn-w-100 mr-2">确定</button>
              </div>
            </div>

          </form>
        </div>
      @endcomponent
    </div>
  </div>
@stop

@section('scripts')
<script>
var $chapters = $('.chapters');
var $hiddenNode = $('#chapters_hidden');
var maxId = 1, maxOrder = 1;
var strNode = '<div class="dummy-node">'
  + '<input class="form-control float-left spacing" type="text" value="[value]" />'
  + '<a class="float-right button" onclick="handle(this, \'[symbol]\')">'
  + '<i class="anticon icon-[symbol]"></i>'
  + '</a>'
  + '</div>';

function handle(btn, plusOrMinus) {
  var $row = $(btn).parent();
  var hasValue = $row.children('input').val();
  var node;

  // Add row
  if (plusOrMinus == 'plus') {
    node = strNode.replace(/\[value\]/g, '').replace(/\[symbol\]/g, 'minus');
    $(node).appendTo($chapters);
  } else {
    // Delete row. Confirm when it contains contents.
    if (hasValue) {
      if (confirm('确认删除 ' + hasValue + ' ？')) {
        $row.remove();
      }
    } else {
      $row.remove();
    }
  }

  return false;
}

$(document).ready(function(){
  // The old function can retrieve data from input field or db
  var hasChapters = $hiddenNode.val();

  // Set chapter items
  if (hasChapters) {
    var chapters = JSON.parse(hasChapters);

    // List all chapters
    for (var i = 0; i < chapters.length; i++) {
      var chapter = chapters[i];
      var node = strNode.replace(/\[value\]/g, chapter.name);

      // Set the first node with plus button
      if (i == 0) {
        node = node.replace(/\[symbol\]/g, 'plus');
      } else {
        // Set the other nodes with minus button
        node = node.replace(/\[symbol\]/g, 'minus');
      }

      // Store data and append to wrapper
      $(node).data(chapter).appendTo($chapters);

      // Calculate the next id and order
      maxId = chapter.id;
      maxOrder = chapter.order;
    }

  } else {
    // When creating a blank new course
    var node = strNode.replace(/\[value\]/g, '').replace(/\[symbol\]/g, 'plus');
    $(node).appendTo($chapters);
  }

  // Submit
  $('#course_form').submit(function(e){
    // Compose string chapters
    var strChapters = '';

    $('.dummy-node').each(function(i){
      var data = $(this).data();

      if (data.id) {
        var json = {
          'id': data.id,
          'name': $(this).children('input').val(),
          'topics': data.topics,
          'order': data.order
        }
        strChapters += JSON.stringify(json) + ',';
      } else {
        maxId += 1;
        maxOrder += 1;
        var json = {
          'id': maxId,
          'name': $(this).children('input').val(),
          'topics': [],
          'order': maxOrder
        }
        strChapters += JSON.stringify(json) + ',';
      }
    });

    // Post chapters
    strChapters = '[' + strChapters.substring(0, strChapters.length-1) + ']';
    $hiddenNode.val(strChapters);
  });
})
</script>
@stop