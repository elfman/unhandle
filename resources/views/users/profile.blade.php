@extends('layouts.app')

@section('title', $user->name. '的个人中心')

@section('content')
<div class="user-center">
  <div class="profile">
    <div class="container">
      <div class="avatar">
        <img {{ avatarAttr($user) }}>
      </div>
      <div class="summery">
        <div class="name">{{ $user->name }}</div>
        <div class="reputation">{{ $user->reputation }} 声望</div>
      </div>
      <div class="introduction">
        {{ $user->introduction }}
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="sider col-md-3">
        <ul class="list-group">
          <a class="list-group-item {{ active_class(Route::currentRouteName() === 'users.show') }}" href="{{ route('users.show', $user->id) }}">
            {{ heOrMe($user) }}的主页
          </a>
          <a class="list-group-item {{ active_class(Route::currentRouteName() === 'users.questions') }}" href="{{ route('users.questions', $user->id) }}">
            {{ heOrMe($user) }}的问题
          </a>
          <a class="list-group-item {{ active_class(Route::currentRouteName() === 'users.answers') }}" href="{{ route('users.answers', $user->id) }}">
            {{ heOrMe($user) }}的回答
          </a>
        </ul>
      </div>
      <div class="content col-md-9">
        @yield('profile-content')
      </div>
    </div>
  </div>
</div>
@endsection