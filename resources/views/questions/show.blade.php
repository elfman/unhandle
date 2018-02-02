@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="//cdn.bootcss.com/github-markdown-css/2.10.0/github-markdown.css">
@endsection

@section('content')
<div class="container">
    <div class="card question">
        <div class="title">{{ $question->title }}</div>
        <hr>
        <div class="content">
            <div class="left">
                <div class="vote">
                    <div class="up"><i class="fa fa-sort-up"></i></div>
                    <div class="vote-count">{{ $question->vote_count }}</div>
                    <div class="down"><i class="fa fa-sort-down"></i></div>
                </div>
            </div>
            <div class="right">
                <div class="body markdown-body">
                    {!! clean(Parsedown::instance()->text($answer->body)) !!}
                </div>
                <div class="actions">
                    <div class="tags">
                        @foreach($question->tags->pluck('name')->toArray() as $tag)
                            <span class="badge badge-info">{{ $tag }}</span>
                        @endforeach
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
        <div class="answer">
            <div class="left">
                <div class="vote">
                    <div class="up"><i class="fa fa-sort-up"></i></div>
                    <div class="vote-count">{{ $answer->vote_count }}</div>
                    <div class="down"><i class="fa fa-sort-down"></i></div>
                </div>
            </div>
            <div class="right">
                <div class="body markdown-body">
                    {!! clean(Parsedown::instance()->text($answer->body)) !!}
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
