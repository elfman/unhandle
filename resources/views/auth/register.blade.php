@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="col-12 col-md-8">
        <div class="card">
          <div class="card-header">注册</div>

          <div class="card-body row">
            <form class="form-horizontal col-md-6" method="POST" action="{{ route('register') }}">
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="control-label">用户名</label>

                <div>
                  <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required
                         autofocus>

                  @if ($errors->has('name'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="control-label">邮箱</label>

                <div>
                  <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                  @if ($errors->has('email'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="control-label">密码</label>

                <div>
                  <input id="password" type="password" class="form-control" name="password" required>

                  @if ($errors->has('password'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group">
                <label for="password-confirm" class="control-label">确认密码</label>

                <div>
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                         required>
                </div>
              </div>

              <div class="form-group">
                <div>
                  <button type="submit" class="btn btn-primary">
                    注册
                  </button>
                </div>
              </div>

            </form>
            <div class="col-md-6">
              <div>已有账号，前往<a href="{{ route('login') }}">登录</a></div>
              <div class="oauth">
                使用其它网站账号注册：
                  <a href="{{ route('oauth.github.redirect') }}">
                    <i class="fa fa-github"></i>
                  </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
