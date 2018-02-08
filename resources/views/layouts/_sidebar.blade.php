<div class="col-md-3 side-bar">
  <div class="card reputation-rank">
    <div class="card-header">
      排行榜
    </div>
    <div class="card-body">
      <div class="users">
        @foreach($reputationRank as $index => $user)
        <div class="item-user">
          <span>{{ $index }}.</span>
          <img {{ avatarAttr($user) }}>
          <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
          <span class="reputation">+{{ $user->last_week_reputation }}</span>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>