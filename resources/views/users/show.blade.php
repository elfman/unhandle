@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-3 hidden-sm user-info">
        <div class="card">
          <div class="card-body">
            <div align="center">
              <img {{ avatarAttr() }}
                   alt="{{ $user->name }}" class="img-fluid">
            </div>
            <div>
              <hr>
              <h4><strong>个人简介</strong></h4>
              <p>{{ $user->introduction }}</p>
              <hr>
              <h4><strong>注册于</strong></h4>
              <p>{{ $user->created_at->diffForHumans() }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-9">
        <div class="card">
          <div class="card-header info-header">
            {{ $user->name }} <small>{{ $user->email }}</small>
          </div>
          <div class="card-body">
            暂无数据
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection