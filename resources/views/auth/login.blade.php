@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-body">
          <ul class="nav nav-tabs nav-fill" role="tablist">
            <li class="nav-item">
              <a id="weixin-tab" class="nav-link" href="#weixin" data-toggle="tab" role="tab" aria-controls="weixin" aria-selected="false">微信登陆</a>
            </li>
            <li class="nav-item">
              <a id="account-tab" class="nav-link active" href="#account" data-toggle="tab" role="tab" aria-controls="account" aria-selected="true">帐号登录</a>
            </li>
          </ul>
          <div class="tab-content">
            {{-- 微信登录 --}}
            <div class="tab-pane fade" id="weixin" role="tabpanel" aria-labelledby="weixin-tab">
                <div class="text-center">开发中，稍后上线</div>
            </div>
            {{-- 帐号登录 --}}
            <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
              <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group row {{ $errors->has('account') ? ' has-error' : '' }}">
                  <label for="account" class="col-3 col-form-label text-right">帐　号</label>
                  <div class="col-md-7">
                    <input id="account" type="text" class="form-control" name="account" value="{{ old('account') }}" placeholder="请输入手机或邮箱" required autofocus>

                    @if ($errors->has('account'))
                      <span class="form-text">
                        <strong>{{ $errors->first('account') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>

                <div class="form-group row {{ $errors->has('password') ? ' has-error' : '' }}">
                  <label for="password" class="col-3 col-form-label text-right">密　码</label>
                  <div class="col-md-7">
                    <input id="password" type="password" class="form-control" name="password" placeholder="请输入密码" required>

                    @if ($errors->has('password'))
                      <span class="form-text">
                        <strong>{{ $errors->first('password') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>

                <div class="form-group row {{ $errors->has('captcha') ? ' has-error' : '' }}">
                  <label for="captcha" class="col-3 col-form-label text-right">验证码</label>
                  <div class="col-md-7">
                    <input id="captcha" type="text" class="form-control" name="captcha" placeholder="请输入验证码" required>

                    @if ($errors->has('captcha'))
                      <span class="form-text">
                        <strong>{{ $errors->first('captcha') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-7 offset-md-3">
                    <div class="checkbox">
                      <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 下次自动登录</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-7 offset-md-3">
                    <button type="submit" class="btn btn-primary btn-w-100">登录</button>
                    <a class="btn btn-link text-right" href="{{ route('password.request') }}">忘记密码？</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection