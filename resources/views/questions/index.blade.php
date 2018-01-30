@extends('layouts.app')

@section('title', '所有问题')

@section('content')
<div class="container">
    <div class="question-list">
        @foreach($questions as $question)
        <div class="row question">
            <div class="col-md-1 left">
                <div class="vote-count">{{ $question->vote_count }} <span>votes</span></div>
                <div class="answer-count">{{ $question->answer_count }} <span>answers</span></div>
                <div class="view-count">{{ $question->view_count }} <span>views</span></div>
            </div>
            <div class="right">
                <div class="title">{{ $question->title }}</div>
                <div class="brief">{{ $question->brief }}</div>
                {{--<div class="tags">--}}
                    {{--@foreach($question->tags as $tag)--}}
                        {{--<span class="badge">{{ $tag->name }}</span>--}}
                    {{--@endforeach--}}
                {{--</div>--}}
                <div class="corn">
                    <div>asked {{ $question->created_at->diffForHumans() }}</div>
                    <div class="user-info">
                        <img {{ avatarAttr($question->user) }} alt="">
                        <div class="username">{{ $question->user->name }}</div>
                        <div class="score">{{ $question->user->score }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection