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
                <input name="slug" id="slug" type="slug" class="form-control {{ checkError($errors, 'slug') }}" value="{{ old('slug', $course->slug) }}" required>
                {!! showErrorFeedback($errors, 'slug') !!}
              </div>
              <div class="col-md-5 col-form-label tips">可用连字符，不能用空格。例如：my-course</div>
            </div>

            <div class="form-group row">
              <label for="cover" class="col-md-2 col-form-label text-md-right">封面图</label>
              <div class="col-md-5"><input type="file" name="cover" id="cover" ></div>
              <div class="col-md-5 col-form-label tips">封面图片，尺寸：500 x 625</div>
            </div>

            @if($course->cover)
              <div class="form-group row">
                <div class="col-md-7 offset-md-2">
                  <label for="cover"><img class="img-fluid img-shadow cover-image" src="{{ $course->cover }}" width="200" style="cursor:pointer" /></label>
                </div>
              </div>
            @endif

            <div class="form-group row">
              <label for="price" class="col-md-2 col-form-label text-md-right">价格</label>
              <div class="col-md-2"><input class="form-control" type="number" name="price" id="price" value="{{ old('price', $course->price) }}" required /></div>
              <div class="col-md-5 offset-md-3 col-form-label tips">单位：分。例如：39.0 元，填写 3990</div>
            </div>

            <div class="form-group row">
              <label for="cover" class="col-md-2 col-form-label text-md-right">分章</label>
              <div class="col-md-5 clearfix chapters">
                <input type="hidden" id="update_chapters" name="update_chapters" value="{{ old('update_chapters', $chapters) }}" />
                <input type="hidden" id="insert_chapters" name="insert_chapters" value="{{ old('insert_chapters') }}" />
                <input type="hidden" id="delete_chapters" name="delete_chapters" value="{{ old('delete_chapters') }}" />
              </div>
              <div class="col-md-5 col-form-label tips">每章标题和排序，排序数越小越靠前</div>
            </div>

            <div class="form-group row">
              <label for="intro" class="col-md-2 col-form-label text-md-right">描述</label>
              <div class="col-md-7"><textarea name="intro" id="intro" class="form-control" rows="7" required minlength="10">{{ old('intro', $course->intro) }}</textarea></div>
              <div class="col-md-3 col-form-label tips">用于首页和课程目录上方</div>
            </div>

            <div class="form-group row">
              <label for="introduction" class="col-md-2 col-form-label text-md-right">介绍</label>
              <div class="col-md-7"><textarea name="introduction" id="introduction" class="form-control" rows="15" required minlength="20">{{ old('introduction', $course->introduction) }}</textarea></div>
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
var URL = window.URL || window.webkitURL;
var $inputCover = $('#cover');
var $imageCover = $('.cover-image');
var uploadedImageURL;

var $chapters = $('.chapters');
var $updateChapters = $('#update_chapters');
var $insertChapters = $('#insert_chapters');
var $deleteChapters = $('#delete_chapters');

var strDummyNode = '<div class="dummy-node">'
  + '<input class="form-control float-left chapter-name spacing" type="text" value="[nameValue]" />'
  + '<input class="form-control float-left chapter-sorting spacing" type="text" value="[sortingValue]" onfocus="this.select()" />'
  + '<a class="float-right button" onclick="handle(this, \'[symbol]\')">'
  + '<i class="anticon icon-[symbol]circleo"></i>'
  + '</a>'
  + '</div>';

function handle(btn, plusOrMinus) {
  var $row = $(btn).parent();
  var hasValue = $row.children('input.chapter-name').val();
  var node;

  if (plusOrMinus == 'plus') {
    // Add a row
    node = strDummyNode
      .replace(/\[nameValue\]/g, '')
      .replace(/\[sortingValue\]/g, '0')
      .replace(/\[symbol\]/g, 'minus');

    $(node).appendTo($chapters);

  } else {
    // Delete a row. Confirm when it contains contents.
    if (hasValue) {
      if (confirm('确认删除 ' + hasValue + ' ？')) {
        // Pump the chapter id to the delete node for later deleting
        $deleteChapters.val($deleteChapters.val() + $row.data().id + ',');
        $row.remove();
      }
    } else {
      $row.remove();
    }
  }

  return false;
}

function setNodeValue($node, str) {
  str = '[' + str.substring(0, str.length-1) + ']';
  $node.val(str);
}

// Form submits
$('#course_form').submit(function(e){
  // Compose string chapters
  var strUpdateChapters = '',
      strInsertChapters = '';

  $('.dummy-node').each(function(i) {
    var data = $(this).data();
    var name = $(this).children('input.chapter-name').val();
    var sorting = $(this).children('input.chapter-sorting').val();
    var json;

    if (name) {
      // Update
      if (data.id) {
        json = {
          'id': data.id,
          'name': name,
          'sorting': sorting
        };
        strUpdateChapters += JSON.stringify(json) + ',';

      // Insert
      } else {
        json = {
          'name': name,
          'sorting': sorting
        };
        strInsertChapters += JSON.stringify(json) + ',';
      }
    }
  });

  // Set node value
  setNodeValue($updateChapters, strUpdateChapters);
  setNodeValue($insertChapters, strInsertChapters);
  setNodeValue($deleteChapters, $deleteChapters.val());
});

// Main
(function() {
  // The old function can retrieve data from input field or db
  var hasChapters = $updateChapters.val();

  // Set chapter items
  if (hasChapters) {
    var chapters = JSON.parse(hasChapters);
    var chapter, node;

    // List all chapters
    for (var i = 0; i < chapters.length; i++) {
      chapter = chapters[i];

      node = strDummyNode
        .replace(/\[nameValue\]/g, chapter.name)
        .replace(/\[sortingValue\]/g, chapter.sorting);

      // Set the first node with plus button
      if (i == 0) {
        node = node.replace(/\[symbol\]/g, 'plus');
      } else { // Set the other nodes with minus button
        node = node.replace(/\[symbol\]/g, 'minus');
      }

      // Store the chapter data to the node which
      // should be appended to the wrapper later.
      $(node).data(chapter).appendTo($chapters);
    }

  } else {
    // When creating a blank new course
    node = strDummyNode
      .replace(/\[nameValue\]/g, '')
      .replace(/\[sortingValue\]/g, '0')
      .replace(/\[symbol\]/g, 'plus');

    $(node).appendTo($chapters);
  }

  // Import image
  if (URL) {
    $inputCover.change(function() {
      var files = this.files;
      var file;

      if (files && files.length) {
        file = files[0];

        if (/^image\/\w+/.test(file.type)) {
          if (uploadedImageURL) {
            URL.revokeObjectURL(uploadedImageURL);
          }
          uploadedImageURL = URL.createObjectURL(file);

          $imageCover.attr('src', uploadedImageURL);
        } else {
          alert('请选择图片文件');
        }
      }
    });
  }

})();
</script>
@stop