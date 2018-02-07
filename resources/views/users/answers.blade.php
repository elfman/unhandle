@extends('users.profile')

@section('profile-content')
<div class="card">
  <div class="card-header">
    {{ heOrMe($user) }}的回答
  </div>
  <div class="card-body">
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
    {{ $answers->links() }}
  @else
    <div class="empty">该用户没有回答过问题</div>
  @endif
  </div>
</div>
@endsection