<div class="media answer-created">
  <a class="d-flex mr-3" href="{{ route('users.show', $notification->data['user_id']) }}">
    <img {{ avatarAttr($notification->data) }} alt="" class="avatar">
  </a>
  <div class="media-body">
    <span class="meta pull-right" title="{{ $notification->created_at }}">
      <span class="fa fa-clock-o" aria-hidden="true"></span>
      {{ $notification->created_at->diffForHumans() }}
    </span>
    <div class="media-heading">
      <a href="{{ route('users.show', $notification->data['user_id']) }}">{{ $notification->data['user_name'] }}</a>
      评论了
      <a href="{{ $notification->data['comment_link'] }}">{{ $notification->data['question_title'] }}</a>
    </div>
    <p>{{ $notification->data['comment_body'] }}</p>

  </div>
</div>