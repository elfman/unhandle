@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
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
                <div class="body">
                    {!! parseMarkdown($question->body) !!}
                </div>
                <div class="actions">
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
</div>
@endsection
