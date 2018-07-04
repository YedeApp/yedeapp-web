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
              <div class="col-md-2"><input class="form-control" type="number" name="price" id="price" value="{{ old('price', $course->price) }}" required></div>
              <div class="col-md-4 offset-md-4 col-form-label tips">单位：分。例如：39.0 元，填写 3990</div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 col-form-label text-md-right">章节</label>
              <div class="col-md-6 clearfix chapters">
                {{-- <input type="hidden" id="update_chapters" name="update_chapters" value="{{ old('update_chapters', $chapters) }}" />
                <input type="hidden" id="insert_chapters" name="insert_chapters" value="{{ old('insert_chapters') }}" />
                <input type="hidden" id="delete_chapters" name="delete_chapters" value="{{ old('delete_chapters') }}" /> --}}
                <input type="hidden" name="chapters_data" id="chapters_data" value="{{ old('chapters_data', $chapters) }}">
                <input type="hidden" name="topics_data" id="topics_data" value="{{ old('topics_data', $topics) }}">
              </div>
              <div class="col-md-4 col-form-label tips">章节标题和排序，排序越小越靠前</div>
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
              <label for="active" class="col-md-2 col-form-label text-md-right">发布</label>
              <div class="col-md-2">
                <select name="active" id="active" class="form-control" required>
                  <option value="1" {{ 1 == old('active', $course->active) ? 'selected' : '' }}>是</option>
                  <option value="0" {{ 0 == old('active', $course->active) ? 'selected' : '' }}>否</option>
                </select>
              </div>
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
/*
 * Refresh uploading image
 *
 * Show the new image before uploading.
 *
 */
var URL = window.URL || window.webkitURL;
var $coverInput = $('#cover');
var $coverImage = $('.cover-image');
var uploadedImageURL;

if (URL) {
  $coverInput.change(function() {
    var files = this.files;
    var file;

    if (files && files.length) {
      file = files[0];

      if (/^image\/\w+/.test(file.type)) {
        if (uploadedImageURL) {
          URL.revokeObjectURL(uploadedImageURL);
        }
        uploadedImageURL = URL.createObjectURL(file);

        $coverImage.attr('src', uploadedImageURL);
      } else {
        alert('请选择图片文件');
      }
    }
  });
}

/*
 * Chapter handling
 *
 * Using concating strings would be an easier solution than directly manipulating DOM elements.
 *
 */
var $chapterList = $('.chapters');
var $deleteButtons = $('.delete-button');
var $addButtons = $('.add-button');
var $storedChapters = $('#chapters_data');
var $storedTopics = $('#topics_data');

// object containing raw string data for later use
var RowString = {
  titleText: '<input class="form-control title" type="text" value="[titleValue]">',
  sortingText: '<input class="form-control sorting" type="text" value="[sortingValue]" onfocus="this.select()">',
  deleteButton: '<a class="button delete-button ml-2" onclick="deleteRow(this)" title="删除"><i class="anticon icon-delete"></i></a>',
  addChapterButton: '<a class="button add-button ml-2" onclick="addChapterRow(this)" title="添加新章"><i class="anticon icon-addfolder"></i></a>',
  addTopicButton: '<a class="button add-button ml-2" onclick="addTopicRow(this)" title="添加小节"><i class="anticon icon-addfile"></i></a>',

  // wrap buttons
  getButtonsDiv: function(buttonsString) {
    return '<div class="buttons">' + buttonsString + '</div>';
  },

  // wrap all
  getDummyDiv: function(rowType, rowString) {
    var rowTypeClass = rowType + '-node';
    return '<div class="dummy ' + rowTypeClass + '">' + rowString  + '</div>';
  }
};

var getRow = function(btn) {
  return $(btn).parent().parent('.dummy');
}

var getTitleFromRow = function(row) {
  return row.children('.title').val();
}

var isChapterRow = function(row) {
  return row.hasClass('chapter-node');
}

var isLastChapterRow = function() {
  if ($('.chapter-node').length > 1) return false;

  return true;
}

var deleteRowAfterConfirm = function(row) {
  var title = getTitleFromRow(row);

  if (title) {
    if (confirm('确认删除「' + title + '」吗？')) {
      row.remove();
    }

  } else {
    row.remove();
  }
}

var deleteRow = function(btn) {
  var $row = getRow(btn);

  // chapter row
  if (isChapterRow($row)) {

    // deleted the last chapter row could cause no adding button to use
    if (isLastChapterRow()) {
      alert('删除失败。课程需要至少 1 个章节');
    } else if (getTitleFromRow($row)) {
      if (confirm('删除整章，包含的小节内容将全部丢失。是否删除？')) deleteRowAfterConfirm($row);
    } else {
      deleteRowAfterConfirm($row);
    }

  } else {
    // topic row
    deleteRowAfterConfirm($row);
  }
}

var addChapterRow = function(btn) {
  var $row = getRow(btn);
  var blankRow = getChapterRowString();

  $(blankRow).insertAfter($row);
}

// pay attention to the difference between adding chapters and topics
var addTopicRow = function(btn) {
  var $row = getRow(btn);
  var blankRow = getTopicRowString();

  if (isChapterRow($row)) {
    $(blankRow).appendTo($row);
  } else {
    $(blankRow).insertAfter($row);
  }
}

// set default values and return an object containing the values
var getValues = function() {
  var type = arguments[0] ? arguments[0] : false, title, sorting;

  if (type === false) return;

  title = arguments[1] ? arguments[1] : '';
  sorting = arguments[2] ? arguments[2] : 0;

  return {
    type: type,
    title: title,
    sorting: sorting
  };
}

// fill with data
var getRowString = function(type, title, sorting) {
  return arguments[0]
      .replace(/\[titleValue\]/g, arguments[1].title)
      .replace(/\[sortingValue\]/g, arguments[1].sorting);
}

var getChapterRowString = function() {
  // set default value
  var values = getValues('chapter', arguments[0], arguments[1]);

  // combine to a div wrapping the chapter
  var texts = RowString.titleText + RowString.sortingText;
  var buttons = RowString.getButtonsDiv(RowString.deleteButton + RowString.addChapterButton + RowString.addTopicButton);
  var div = RowString.getDummyDiv(values.type, texts + buttons);

  return getRowString(div, values);
}

var getTopicRowString = function() {

  // set default value
  var values = getValues('topic', arguments[0], arguments[1]);

  // combine to a div wrapping the topic
  var texts = RowString.titleText + RowString.sortingText;
  var buttons = RowString.getButtonsDiv(RowString.deleteButton + RowString.addTopicButton);
  var div = RowString.getDummyDiv(values.type, texts + buttons);

  return getRowString(div, values);
}

var showTopics = function(parent, topic) {
  var row = getTopicRowString(topic.title, topic.sorting);
  $(row).appendTo(parent);
}

var showChapters = function() {
  var chapters = $storedChapters.val();
  var topics = $storedTopics.val();
  var row, $row;

  if (chapters) {
    // update
    JSON.parse(chapters).forEach(function(chapter) {

      row = getChapterRowString(chapter.name, chapter.sorting);

      // It's a little bit tricky here. If you use $(row).appendTo(...) to append to $chapterList, the $(row)
      // will always create a new DOM element, also the reference of the $(row) won't be the same in the iteration,
      // causing later topic elements appending to a no appearing chapter.
      $row = $(row);
      $row.data(chapter).appendTo($chapterList);

      // not a good approch, but worked.
      JSON.parse(topics).forEach(function(topic) {
        if (topic.chapter_id === chapter.id) {
          showTopics($row, topic);
        }
      });

    });

  } else {
    // create
    row = getChapterRowString();

    $(row).appendTo($chapterList);
  }
}

var init = function() {
  showChapters();
}

init();
</script>
@stop