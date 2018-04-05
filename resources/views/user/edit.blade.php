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
            <input name="name" id="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" min-length="3" required>
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
          <label for="phone" class="col-md-2 col-form-label text-md-right">个人简介</label>
          <div class="col-md-5">
            <textarea name="introduction" id="introduction" class="form-control" rows="4">{{ old('introduction', $user->introduction) }}</textarea>
          </div>
          <div class="col-md-5 col-form-label tips">一句话简短介绍自己</div>
        </div>

        <div class="form-group row">
          <label for="avatar" class="col-md-2 col-form-label text-md-right">头　像</label>
          <div class="col-md-5">
            <input type="file" name="avatar" id="avatar">
            @if ($user->avatar)
              <label for="avatar">
                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="img-thumbnail preview" width="200">
              </label>
            @endif
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
  @endcomponent
@endsection