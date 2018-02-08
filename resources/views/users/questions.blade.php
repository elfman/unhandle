@extends('users.profile')

@section('profile-content')
  <div class="card">
    <div class="card-header">
      {{ heOrMe($user) }}的问题
    </div>
    <div class="card-body">
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
        {{ $questions->links() }}
      @else
      <div class="empty">该用户没有提过问题</div>
      @endif
    </div>
  </div>
@endsection