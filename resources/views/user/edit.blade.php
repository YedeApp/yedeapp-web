@extends('layouts.app')

@section('title', '编辑 ' . $user->name . ' 个人资料')

@section('content')
  @component('components.card')

    {{-- Head --}}
    <div class="head">
      <svg class="icon" aria-hidden="true"><use xlink:href="#icon-form"></use></svg> 编辑个人资料
    </div>

    {{-- Error area --}}
    @include('components.error')

    {{-- Body and form --}}
    <div class="body">
      <form action="{{ route('user.update', $user->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
        {{ method_field('PUT') }}
        {{ csrf_field() }}

        <div class="form-group row">
          <label for="name" class="col-md-2 col-form-label text-md-right">用户名</label>
          <div class="col-md-5">
            <input name="name" id="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" min-length="2" required>
          </div>
          <div class="col-md-5 col-form-label tips">可使用中英文</div>
        </div>

        <div class="form-group row">
          <label for="email" class="col-md-2 col-form-label text-md-right">邮　箱</label>
          <div class="col-md-5">
            <input name="email" id="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
          </div>
          <div class="col-md-5 col-form-label tips">邮箱可用于登录和找回密码</div>
        </div>

        <div class="form-group row">
          <label for="phone" class="col-md-2 col-form-label text-md-right">手　机</label>
          <div class="col-md-5">
            <input name="phone" id="phone" type="text" class="form-control" value="{{ old('phone', $user->phone) }}" required>
          </div>
          <div class="col-md-5 col-form-label tips">手机号可用于登录</div>
        </div>

        <div class="form-group row">
          <label for="introduction" class="col-md-2 col-form-label text-md-right">个人简介</label>
          <div class="col-md-5">
            <textarea name="introduction" id="introduction" class="form-control" rows="4">{{ old('introduction', $user->introduction) }}</textarea>
          </div>
          <div class="col-md-5 col-form-label tips">一句话简短介绍自己</div>
        </div>

        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">头　像</label>
          <div class="col-md-5">
            <input name="avatar" id="avatar" type="file" accept="image/png,image/jpeg">
            <label for="avatar">
              <img id="user-avatar" src="{{ $user->avatar }}" alt="{{ $user->name }}" class="img-thumbnail img-avatar" width="200">
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
            <div class="image-tools"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-cropper btn-w-100 mr-2">保存</button>
            <button type="button" class="btn btn-secondary btn-confirm-no btn-w-100" data-dismiss="modal">取消</button>
          </div>
        </div>
      </div>
    </div>
  @endcomponent
@endsection

{{-- Cropper styles --}}
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/cropper.min.css') }}">
@endsection

{{-- Cropper scripts --}}
@section('scripts')
<script type="text/javascript"  src="{{ asset('js/cropper.min.js') }}"></script>
<script type="text/javascript"  src="{{ asset('js/jquery-cropper.min.js') }}"></script>

<script>
var $inputAvatar = $('#avatar');
var $userAvatar = $('#user-avatar');
var $uploadAvatar = $('#upload-avatar');

// Create and init cropper
var options = {
  aspectRatio: 1 / 1,
}
$uploadAvatar.cropper(options);

// Get cropper instance after initialized.
var cropper = $uploadAvatar.data('cropper');
var originalImageURL = $uploadAvatar.attr('src');
var uploadedImageType = 'image/jpeg';
var uploadedImageName = 'cropped.jpg';
var uploadedImageURL;

// Get DataURL from uploaded image.
$inputAvatar.change(function() {
  // Show the modal
  $('#modalCropper').modal('show');

  var files = this.files;
  var file;

  if (cropper && files && files.length) {
    file = files[0];

     if (/^image\/\w+/.test(file.type)) {
      uploadedImageType = file.type;
      uploadedImageName = file.name;

      if (uploadedImageURL) {
        URL.revokeObjectURL(uploadedImageURL);
      }

      image.src = uploadedImageURL = URL.createObjectURL(file);
      cropper.destroy();
      cropper = new Cropper(image, options);
      inputImage.value = null;
    } else {
      window.alert('Please choose an image file.');
    }
  }

  var reader = new FileReader();

  // Get DataURL from reader.result then refresh image's src.
  reader.onload = function(){
    var url = reader.result;
    // setImageURL($imgCropper, url);
    $imgCropper.cropper('reset', true).cropper('replace', url);
  };
  reader.readAsDataURL(file);
})

// Clear the avatar input value when modal hiding, so that
// input's onchange event can be triggered again
$('#modalCropper').on('hide.bs.modal', function (event) {
  $inputAvatar.val('');
})
</script>
@endsection