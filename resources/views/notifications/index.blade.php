@extends('layouts.app')

@section('title')
  我的通知
@endsection

@section('content')
    <div class="container">
      <div class="col-md-10 col-md-offset-1">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <span class="fa fa-bell"></span> 我的通知
            </div>
            <hr>
            @if ($notifications->count())
              <div class="notification-list">
                @foreach($notifications as $notification)
                  <div class="my-4">
                    @include('notifications.types._' . snake_case(class_basename($notification->type)))
                  </div>
                @endforeach
              </div>
            @else
              <div class="empty-block">没有消息通知！</div>
            @endif
          </div>
        </div>
      </div>
    </div>
@endsection