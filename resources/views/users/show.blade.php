@extends('users.profile')

@section('profile-content')
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
                  <li class="list-group-item question-item">
                    <span class="vote-count">{{ $question->vote_count }} 票</span>
                    <a href="{{ $question->link() }}" class="title">{{ $question->title }}</a>
                    <span class="time">{{ $question->created_at->format('y-m-d h:i') }}</span>
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
                      <li class="list-group-item answer-item">
                        <span class="vote-count">{{ $answer->vote_count }} 票</span>
                        <a href="{{ $answer->question->link('#answer'. $answer->id) }}" class="title">{{ $answer->question->title }}</a>
                        <span class="time pull-right">{{ $answer->created_at->format('y-m-d h:i') }}</span>
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
@endsection