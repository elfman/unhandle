@extends('layouts.app')

@section('title', '所有问题')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="question-list">
          @foreach($questions as $question)
            <div class="row question">
              <div class="left">
                <div class="vote-count">
                  <span>{{ $question->vote_count }}</span> votes
                </div>
                <div class="answer-count">
                  <span>{{ $question->answer_count }}</span> answers
                </div>
                <div class="view-count">
                  <span>{{ shortenNumber($question->latestViewCount()) }}</span> views
                </div>
              </div>
              <div class="right">
                <div class="title">
                  <a href="{{ route('questions.show', $question->id) }}">
                    {{ $question->title }}
                  </a>
                </div>
                <div class="brief">{{ $question->brief }}</div>
                <div class="actions">
                  <div class="tags">
                    @foreach($question->tags as $tag)
                      <span class="badge badge-info">{{ $tag->name }}</span>
                    @endforeach
                  </div>
                  <div class="user-info owner">
                    <div class="user-action-time">创建于 {{ $question->created_at }}</div>
                    <div>
                      <img class="avatar" {{ avatarAttr($question->user) }} alt="">
                      <div class="user-details">
                        <div class="name">
                          <a href="{{ route('users.show', $question->user->id) }}">
                            {{ $question->user->name }}
                          </a>
                        </div>
                        <div class="reputation">{{ $question->user->reputation }} 声望</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>
          @endforeach
        </div>
        {!! $questions->render() !!}
      </div>
      @include('layouts._sidebar')
    </div>
  </div>
@endsection