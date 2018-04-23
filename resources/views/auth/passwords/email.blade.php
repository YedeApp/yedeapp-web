@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-6 offset-md-3">
    <div class="card">
      <div class="card-header">发送密码重置邮件</div>
      <div class="card-body">
        <form method="POST" action="{{ route('password.email') }}">
          {{ csrf_field() }}

          <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label text-md-right">用户邮箱</label>
            <div class="col-md-7">
              <input id="email" type="email" class="form-control {{ checkError($errors, 'email') }}" name="email" value="{{ old('email') }}" placeholder="请输入注册时预留的邮箱" required>
              {!! showErrorFeedback($errors, 'email') !!}
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3">
              <button type="submit" class="btn btn-primary btn-w-120">发送邮件</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection
