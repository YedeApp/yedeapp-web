@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-6 offset-md-3">
    <div class="card">
      <div class="card-header">重置密码</div>
      <div class="card-body">
        {{-- Error area --}}
        @include('components.error')

        <form method="POST" action="{{ route('password.request') }}">
          {{ csrf_field() }}
          {{-- Password reset function need this one, not for csrf --}}
          <input type="hidden" name="token" value="{{ $token }}">

          <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label text-md-right">邮　箱</label>
            <div class="col-md-7">
              <input id="email" name="email" type="email" class="form-control {{ checkError($errors, 'email') }}" value="{{ $email or old('email') }}" placeholder="接收密码重置邮件的邮箱" required autofocus>
              {!! showErrorFeedback($errors, 'email') !!}
            </div>
          </div>

          <div class="form-group row">
            <label for="password" class="col-md-3 col-form-label text-md-right">新密码</label>
            <div class="col-md-7">
              <input id="password" name="password" type="password" class="form-control {{ checkError($errors, 'password') }}" placeholder="请输入新密码" required>
              {!! showErrorFeedback($errors, 'password') !!}
            </div>
          </div>

          <div class="form-group row">
            <label for="password-confirm" class="col-md-3 col-form-label text-md-right">再次确认</label>
            <div class="col-md-7">
              <input id="password-confirm" name="password_confirmation" type="password" class="form-control {{ checkError($errors, 'password_confirmation') }}" placeholder="请再次确认新密码" required>
              {!! showErrorFeedback($errors, 'password_confirmation') !!}
            </div>
          </div>

          <div class="form-group row">
              <div class="col-md-7 offset-md-3">
                  <button type="submit" class="btn btn-primary btn-w-120">确定</button>
              </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
