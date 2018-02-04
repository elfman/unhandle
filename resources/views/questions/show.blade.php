@extends('layouts.app')

@section('style')
  <link rel="stylesheet" href="//cdn.bootcss.com/github-markdown-css/2.10.0/github-markdown.css">
@endsection

@section('content')
  <div class="container" id="content">
    <div class="card question" data-id="{{ $question->id }}">
      <div class="title">{{ $question->title }}</div>
      <hr>
      <div class="content">
        <div class="left">
          <voter
              type="questions"
              :id="{{ $question->id }}"
              :vote-count="{{ $question->vote_count }}"
              vote-status="{{ $question->voted() }}"
          ></voter>
        </div>
        <div class="right">
          <div class="body markdown-body">
            {!! clean(Parsedown::instance()->text($question->body)) !!}
          </div>
          <div class="actions">
            <div>
              <div class="tags">
                @foreach($question->tags->pluck('name')->toArray() as $tag)
                  <span class="badge badge-info">{{ $tag }}</span>
                @endforeach
              </div>
              <div class="operations">
                @can('update', $question)
                <a href="{{ route('questions.edit', $question->id) }}">编辑</a>
                @endcan
                @can('destroy', $question)
                <a href="javascript:void(0)" class="remove-question">删除</a>
                @endcan
              </div>
            </div>
            <div class="user-info owner">
              <div class="user-action-time">asked {{ $question->created_at }}</div>
              <div>
                <img class="avatar" {{ avatarAttr($question->user) }} alt="">
                <div class="user-details">
                  <div class="name">
                    <a href="{{ route('users.show', $question->user->id) }}">
                      {{ $question->user->name }}
                    </a>
                  </div>
                  <div class="score">{{ $question->user->email }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <div class="answer-list">
      <div class="answer-count">{{ count($question->answers) }} Answers</div>
      @foreach($question->answers as $answer)
        <div class="answer" id="answer{{ $answer->id }}" data-id="{{ $answer->id }}">
          <div class="left">
            <voter
                type="answers"
                :id="{{ $answer->id }}"
                :vote-count="{{ $answer->vote_count }}"
                vote-status="{{ $answer->voted() }}"
            ></voter>
          </div>
          <div class="right">
            <div class="body markdown-body">
              {!! clean(Parsedown::instance()->text($answer->body)) !!}
            </div>
            <div class="actions">
              <div class="operations">
                @can('update', $answer)
                  <a href="{{ route('answers.edit', $answer->id) }}">编辑</a>
                @endcan
                @can('destroy', $answer)
                  <a href="javascript:void(0)" class="remove-answer">删除</a>
                @endcan
              </div>
              <div class="user-info">
                <div class="user-action-time">answered {{ $answer->created_at }}</div>
                <div>
                  <img class="avatar" {{ avatarAttr($answer->user) }} alt="">
                  <div class="user-details">
                    <div class="name">
                      <a href="{{ route('users.show', $answer->user->id) }}">
                        {{ $answer->user->name }}
                      </a>
                    </div>
                    <div class="score">{{ $answer->user->email }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
      @endforeach
    </div>

    <div class="add-answer">
      <a class="btn btn-primary" role="button" href="{{ route('answers.create', $question->id) }}">
        回答问题
      </a>
    </div>
  </div>
@endsection

@section('script')
  <script src="/js/page-question-show.js"></script>
@endsection
