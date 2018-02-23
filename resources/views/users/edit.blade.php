@extends('layouts.app')

@section('title', '编辑个人资料')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
    <div class="col-12 col-md-8">
      <div class="card">
        <div class="card-header">
          <span class="card-title"><i class="fa fa-edit"></i> 编辑个人资料</span>
        </div>
        <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
          <div class="card-body">
            @include('common.error')
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}

            <div class="form-group">
              <label for="name-field">用户名</label>
              <input class="form-control" type="text" name="name" id="name-field"
                     value="{{ old('name', $user->name) }}">
            </div>
            <div class="form-group">
              <label for="name-field">个人简介</label>
              <textarea class="form-control" name="introduction" id="introduction-field"
                        rows="3">{{ old('introduction', $user->introduction) }}</textarea>
            </div>
            <div class="form-group">
              <label for="" class="avatar-label">用户头像</label>
              <input class="form-control-file" type="file" name="avatar">
              @if($user->avatar)
                <br>
                <img class="img-fluid img-thumbnail" src="{{ $user->avatar }}" alt="avatar">
              @endif
            </div>
            <div class="form-group oauth">
              <label>其它网站账号</label>
              <div>
                <div><i class="fa fa-github"></i> Github:
                  @if ($user->github_id)
                  {{ $user->github_name }} <a href="{{ route('oauth.github.unbind') }}">解绑</a>
                  @else
                    尚未绑定 <a href="{{ route('oauth.github.redirect') }}">绑定</a>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">保存</button>
          </div>
        </form>
      </div>
    </div>
    </div>
  </div>
@endsection