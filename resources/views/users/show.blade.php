@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-3 hidden-sm user-profile">
        <div class="card">
          <div class="card-body">
            <div align="center">
              <img {{ avatarAttr($user) }}
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
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" role="tab" href="#questions" id="questions-tab" aria-controls="questions" aria-selected="true">
                  @if ($user->id === Auth::id())
                  我的问题
                  @else
                  Ta 的问题
                  @endif
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" role="tab" href="#answers" id="answers-tab" aria-controls="answers" aria-selected="false">
                  @if ($user->id === Auth::id())
                    我的回答
                  @else
                    Ta 的回答
                  @endif
                </a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="questions" role="tabpanel" aria-labelledby="questions-tab">
                @if ($questions->count() > 0)
                <ul class="list-group list-group-flush">
                  @foreach($questions as $question)
                  <li class="list-group-item">
                    <span class="vote-count">{{ $question->vote_count }} 票</span>
                    <span class="title">{{ $question->title }}</span>
                    <span class="time pull-right">{{ $question->created_at->format('y年m月d日 h:i') }}</span>
                  </li>
                  @endforeach
                </ul>
                  @if ($questions->hasMorePages())
                    <a href="{{ route('users.questions', $user->id) }}" class="view-all">查看全部</a>
                  @endif
                @else
                  <div class="empty">该用户没有提过问题</div>
                @endif
              </div>
              <div class="tab-pane fade" id="answers" role="tabpanel" aria-labelledby="answers-tab">
                @if ($answers->count() > 0)
                  <ul class="list-group list-group-flush">
                    @foreach($answers as $answer)
                      <li class="list-group-item">
                        <span class="vote-count">{{ $answer->vote_count }} 票</span>
                        <span class="title">{{ $answer->question->title }}</span>
                        <span class="time pull-right">{{ $answer->created_at->format('y年m月d日 h:i') }}</span>
                      </li>
                    @endforeach
                  </ul>
                  @if ($answers->hasMorePages())
                    <a href="{{ route('users.answers', $user->id) }}" class="view-all">查看全部</a>
                  @endif
                @else
                  <div class="empty">该用户没有回答过问题</div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection