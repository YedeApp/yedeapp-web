@extends('layouts.app')

@section('title', '编辑 ' . $user->name . ' 个人资料')

@section('content')
  <div class="row">

    {{-- Left side --}}
    <div class="col-md-3">
      @component('components.card')
        @include('user._sidebar')
      @endcomponent
    </div>

    {{-- Right side --}}
    <div class="col-md-9">
      @component('components.card')
        {{-- Head --}}
        <div class="head">
          <svg class="icon" aria-hidden="true"><use xlink:href="#icon-form"></use></svg> 编辑个人资料
        </div>

        {{-- Body and form --}}
        <div class="body">
          {{-- Show error --}}
          @include('components.error')

          <form action="{{ route('user.update', $user->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <div class="form-group row">
              <label for="name" class="col-md-2 col-form-label text-md-right">用户名</label>
              <div class="col-md-5">
                <input name="name" id="name" type="text" class="form-control {{ checkError($errors, 'name') }}" value="{{ old('name', $user->name) }}" min-length="2" required>
                {!! showErrorFeedback($errors, 'name') !!}
              </div>
              <div class="col-md-5 col-form-label tips">只用于显示，可使用中英文</div>
            </div>

            <div class="form-group row">
              <label for="email" class="col-md-2 col-form-label text-md-right">邮　箱</label>
              <div class="col-md-5">
                <input name="email" id="email" type="email" class="form-control {{ checkError($errors, 'email') }}" value="{{ old('email', $user->email) }}">
                {!! showErrorFeedback($errors, 'email') !!}
              </div>
              <div class="col-md-5 col-form-label tips">邮箱用于登录和找回密码</div>
            </div>

            <div class="form-group row">
              <label for="phone" class="col-md-2 col-form-label text-md-right">手　机</label>
              <div class="col-md-5">
                <input name="phone" id="phone" type="text" class="form-control {{ checkError($errors, 'phone') }}" value="{{ old('phone', $user->phone) }}" required>
                {!! showErrorFeedback($errors, 'phone') !!}
              </div>
              <div class="col-md-5 col-form-label tips">手机号可用于登录</div>
            </div>

            <div class="form-group row">
              <label for="introduction" class="col-md-2 col-form-label text-md-right">个人简介</label>
              <div class="col-md-5">
                <textarea name="introduction" id="introduction" class="form-control {{ checkError($errors, 'introduction') }}" rows="4">{{ old('introduction', $user->introduction) }}</textarea>
                {!! showErrorFeedback($errors, 'introduction') !!}
              </div>
              <div class="col-md-5 col-form-label tips">一句话简短介绍自己</div>
            </div>

            <div class="form-group row">
              <label class="col-md-2 col-form-label text-md-right">头　像</label>
              <div class="col-md-5">
                <input name="avatar" id="avatar" type="file" accept="image/png,image/jpeg">
                <label for="avatar" class="avatar-wrapper">
                  <img id="avatar-image" src="{{ $user->avatar }}" alt="{{ $user->name }}" class="img-thumbnail img-avatar" width="200">
                  <div class="avatar-mask">
                    <div class="mask-bg"></div>
                    <div class="mask-content">
                      <div class="mask-icon"><svg class="icon" aria-hidden="true" style="width:40px;height:40px;"><use xlink:href="#icon-camera"></use></svg></div>
                      <div class="mask-text">修改我的头像</div>
                    </div>
                  </div>
                </label>
              </div>
              <div class="col-md-5 col-form-label tips">请上传小于 1M 的图片</div>
            </div>

            <div class="form-group row">
              <div class="col-md-5 offset-md-2">
                <button type="submit" class="btn btn-primary btn-w-100 mr-2">确定</button>
                {{-- <a href="{{ $user->link() }}" role="button" class="btn btn-secondary btn-w-100">返回</a> --}}
              </div>
            </div>

          </form>
        </div>

        {{-- Cropper modal --}}
        <div class="modal fade" id="modalCropper" tabindex="-1" role="dialog" aria-labelledby="modalCropperLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">编辑头像</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="image-wrapper"><img id="upload-avatar"></div>
                <div class="image-tools">
                  <button type="button" class="btn btn-secondary" data-method="reset">
                    <span class="wrapper" data-toggle="tooltip" title="刷新">
                      <span class="fa fa-refresh"></span>
                    </span>
                  </button>
                  <button type="button" class="btn btn-secondary" data-method="zoom" data-option="0.1">
                    <span class="wrapper" data-toggle="tooltip" title="放大">
                      <span class="fa fa-search-plus"></span>
                    </span>
                  </button>
                  <button type="button" class="btn btn-secondary" data-method="zoom" data-option="-0.1">
                    <span class="wrapper" data-toggle="tooltip" title="缩小">
                      <span class="fa fa-search-minus"></span>
                    </span>
                  </button>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-cropper btn-w-100 mr-2" data-dismiss="modal">保存</button>
                <button type="button" class="btn btn-secondary btn-confirm-no btn-w-100" data-dismiss="modal">取消</button>
              </div>
            </div>
          </div>
        </div>
      @endcomponent
    </div>
    {{-- End right side--}}

  </div>
@endsection

{{-- Cropper styles --}}
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/cropper.min.css') }}">
@endsection

{{-- Cropper scripts --}}
@section('scripts')
<script type="text/javascript"  src="{{ asset('js/cropper.min.js') }}"></script>
<script type="text/javascript"  src="{{ asset('js/jquery-cropper.min.js') }}"></script>
<script type="text/javascript"  src="{{ asset('js/canvas-to-blob.min.js') }}"></script>

<script>
var URL = window.URL || window.webkitURL;
var API = "{{ route('user.upload', Auth::id()) }}";
var token = '{{ csrf_token() }}';

var $inputAvatar = $('#avatar');
var $userAvatar = $('#avatar-image');
var $uploadAvatar = $('#upload-avatar');
var $headerAvatar = $('header .info .avatar img');
var $btnCropper = $('.btn-cropper');

var originalImageURL = $uploadAvatar.attr('src');
var uploadedImageType = 'image/jpeg';
var uploadedImageName = 'cropped.jpg';
var uploadedImageURL;
var cropper;

// Tooltip
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
})

// Cropper
var options = {
  aspectRatio: 1 / 1,
  minContainerWidth: 300,
  minContainerHeight: 300,
  minCropBoxWidth: 200,
  minCropBoxHeight: 200,
  minCanvasHeight: 230,
  dragMode: 'move',
  cropBoxMovable: false,
  cropBoxResizable: false,
  toggleDragModeOnDblclick: false
}
$uploadAvatar.cropper(options);
cropper = $uploadAvatar.data('cropper');

// Import image
if (URL) {
  $inputAvatar.change(function() {
    // Show modal
    $('#modalCropper').modal('show');

    var files = this.files;
    var file;

    if (!cropper) {
      return;
    }

    if (files && files.length) {
      file = files[0];

      if (/^image\/\w+/.test(file.type)) {
        uploadedImageType = file.type;
        uploadedImageName = file.name;

        if (uploadedImageURL) {
          URL.revokeObjectURL(uploadedImageURL);
        }

        uploadedImageURL = URL.createObjectURL(file);
        $uploadAvatar.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
      } else {
        alert('请选择图片文件');
      }
    }

  });
}

// Methods
$('.image-tools').on('click', '[data-method]', function() {
  var $this = $(this);
  var data = $this.data();
  var cropped;
  var result;

  if ($this.prop('disabled') || $this.hasClass('disabled')) {
    return;
  }

  if (cropper && data.method) {
    // Clone a new one
    data = $.extend({}, data);
    cropped = cropper.cropped;
    result = $uploadAvatar.cropper(data.method, data.option, data.secondOption);
  }
})

// Upload cropped image
$btnCropper.click(function() {
  var canvasOptions = {
    width: 200,
    height: 200,
    minWidth: 200,
    minHeight: 200,
    maxWidth: 4096,
    maxHeight: 4096,
    fillColor: '#fff',
    imageSmoothingEnabled: false,
    imageSmoothingQuality: 'high',
  };

  // Upload cropped image to server if the browser supports `HTMLCanvasElement.toBlob`
  var canvas = $uploadAvatar.cropper('getCroppedCanvas', canvasOptions);
  canvas.toBlob(function (blob) {
    var formData = new FormData();
    formData.append('avatar', blob);
    formData.append('_token', token);

    // Use `jQuery.ajax` method
    $.ajax(API, {
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function () {
        console.log('Upload success');
      },
      error: function () {
        console.log('Upload error');
      }
    });

  }, 'image/jpeg');

  // Refresh new avatar
  var dataURL = canvas.toDataURL();
  $userAvatar.attr('src', dataURL);
  $headerAvatar.attr('src', dataURL);
  $inputAvatar.val('');
});

// Clear the avatar input value when modal's dismissing.
$('#modalCropper').on('hide.bs.modal', function (event) {
  $inputAvatar.val('');
})
</script>
@endsection