@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="col-12 col-md-8">
        <div class="card">
          <div class="card-header">登录</div>

          <div class="card-body row">
            <form class="form-horizontal col-md-6" method="POST" action="{{ route('login') }}">
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="control-label">邮箱</label>

                <div>
                  <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required
                         autofocus>

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
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我
                  </label>
                </div>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary">
                  登录
                </button>

                <a class="btn btn-link" href="{{ route('password.request') }}">
                  忘记密码？
                </a>
              </div>
            </form>
            <div class="col-md-6">
              <div>尚未注册？立即<a href="{{ route('register') }}">注册</a></div>
              <div class="oauth">
                使用其它网站账号登录：
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
  </div>
@endsection
