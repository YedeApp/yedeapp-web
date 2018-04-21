@extends('layouts.app')

@section('title', '修改 ' . $user->name . ' 的密码')

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
          <svg class="icon" aria-hidden="true"><use xlink:href="#icon-key"></use></svg> 修改密码
        </div>

        {{-- Error area --}}
        @include('components.error')

        {{-- Body and form --}}
        <div class="body">
          <form action="{{ route('user.update', $user->id) }}" method="POST" accept-charset="UTF-8">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <div class="form-group row">
              <label for="name" class="col-md-2 col-form-label text-md-right">用户名</label>
              <div class="col-md-5">
                <input name="name" id="name" type="text" class="form-control" value="{{ $user->name }}" disabled>
              </div>
            </div>

            <div class="form-group row">
              <label for="old-password" class="col-md-2 col-form-label text-md-right">原密码</label>
              <div class="col-md-5">
                <input name="old-password" id="old-password" type="password" class="form-control" value="" required>
              </div>
              <div class="col-md-5 col-form-label tips">如忘记密码，请点此 <a href="{{ route('password.request') }}" target="_blank">找回密码</a></div>
            </div>

            <div class="form-group row">
              <label for="old-password" class="col-md-2 col-form-label text-md-right">新密码</label>
              <div class="col-md-5">
                <input name="old-password" id="old-password" type="password" class="form-control" value="" required>
              </div>
              <div class="col-md-5 col-form-label tips">请输入新密码</div>
            </div>

            <div class="form-group row">
              <label for="password-confirm" class="col-md-2 col-form-label text-md-right">确认密码</label>
              <div class="col-md-5">
                <input name="password_confirmation" id="password-confirm" type="password" class="form-control" value="" required>
              </div>
              <div class="col-md-5 col-form-label tips">再次确认新密码</div>
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
    </div>
    {{-- End right side--}}

  </div>
@endsection