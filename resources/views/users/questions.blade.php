@extends('layouts.app')

@section('title', '所有问题')

@section('content')
  <div class="container">
      @if ($questions->count() > 0)
        <ul class="list-group">
          @foreach($questions as $question)
            <li class="list-group-item">
              <span class="vote-count">{{ $question->vote_count }} 票</span>
              <span class="title">{{ $question->title }}</span>
              <span class="time pull-right">{{ $question->created_at->format('y年m月d日 h:i') }}</span>
            </li>
          @endforeach
        </ul>
        {{ $questions->links() }}
      @else
      <div class="empty">该用户没有提过问题</div>
      @endif
  </div>
@endsection