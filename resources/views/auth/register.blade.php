@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-6 offset-md-3">
    <div class="card">
      <div class="card-header">用户注册</div>
      <div class="card-body">
        <form method="POST" action="{{ route('register') }}">
          {{ csrf_field() }}

          <div class="form-group row">
            <label for="phone" class="col-md-3 col-form-label text-md-right">手机号码</label>
            <div class="col-md-7">
              <input class="form-control {{ checkError($errors, 'phone') }}" type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="请输入手机号码" required autofocus>
              {!! showErrorFeedback($errors, 'phone') !!}
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-4 offset-md-3">
              <input class="form-control {{ checkError($errors, 'captcha') }}" type="text" id="captcha" name="captcha" placeholder="短信验证码" required>
              {!! showErrorFeedback($errors, 'captcha') !!}
            </div>
            <div class="col-md-3 mt-2 mt-md-0 pl-md-0">
              <a id="generate_code" class="btn btn-light">获取短信</a>
            </div>
          </div>

          <div class="form-group row">
            <label for="password" class="col-md-3 col-form-label text-md-right">设置密码</label>
            <div class="col-md-7">
              <input class="form-control {{ checkError($errors, 'password') }}" type="password" id="password" name="password" placeholder="请输入密码" required>
              {!! showErrorFeedback($errors, 'password') !!}
            </div>
          </div>

          <div class="form-group row">
            <label for="password_confirm" class="col-md-3 col-form-label text-md-right">确认密码</label>
            <div class="col-md-7">
              <input class="form-control" type="password" id="password_confirm" name="password_confirmation" placeholder="请再次输入密码" required>
            </div>
          </div>

          <div class="form-group row mt-4">
            <div class="col-md-8 offset-md-3">
              <input class="form-check-input" type="checkbox" id="invalidCheck" name="agreement" required>
              <label class="form-check-label" for="invalidCheck">我已阅读并同意 <a href="{{ route('agreement') }}" target="_blank">《野得APP服务协议》</a></label>
              <div class="invalid-feedback">请先阅读并同意服务协议后再注册</div>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3">
              <button type="submit" class="btn btn-primary w-100">注册</button>
            </div>
          </div>

          <div class="form-group row mt-5">
            <div class="col-md-7 offset-md-3 text-center">
              已有帐号？ <a href="{{ route('login') }}">立即登录</a>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
var btnGenerate = $('#generate_code');
var url = "{{ route('smscode') }}";

function countdown(seconds) {
  btnGenerate.addClass('disabled');

  var timer = setInterval(function() {
    if (seconds > 0) {
      btnGenerate.html(seconds + '秒后重发');
      seconds--;
    } else {
      clearInterval(timer);
      btnGenerate.removeClass('disabled');
      btnGenerate.html('获取短信');
    }
  }, 1000);
}

$(document).ready(function() {
  btnGenerate.click(function() {
    var phone = $('#phone').val();
    var regex = /^1[23456789]\d{9}$/g;

    if (!phone) {
        alert('请先输入手机号码');
    } else if (regex.test(phone)) {
      $.get(url, {phone: phone}, function(data) {
        if (data != 1) {
          alert('您之前已获取过短信，请稍后一分钟再试');
        } else {
          countdown(60);
        }
      });
    } else {
      alert('手机号码格式不正确');
    }
  });
});
</script>
@endsection
