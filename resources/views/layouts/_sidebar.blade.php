<div class="col-md-3 side-bar">
  <div class="card reputation-rank">
    <ul class="card-header" role="tablist">
      排行榜
      <ul class="nav nav-pills" role="tablist" id="rankTabs">
        <li class="nav-item">
          <a class="nav-link" id="tab-lastweek" data-toggle="pill" role="tab" aria-controls="rank-lastweek" aria-selected="false" href="#rank-lastweek">上周</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" id="tab-all" data-toggle="pill" role="tab" aria-controls="rank-all" aria-selected="true" href="#rank-all">全部</a>
        </li>
      </ul>
    </ul>
    <div class="card-body">
      <div class="tab-content">
        <div class="tab-pane fade users" role="tabpanel" aria-labelledby="tab-lastweek" id="rank-lastweek">
          @foreach($reputationRank as $index => $user)
            <div class="item-user">
              <span>{{ $index + 1 }}.</span>
              <img {{ avatarAttr($user) }}>
              <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
              <span class="reputation">+{{ $user->last_week_reputation }}</span>
            </div>
          @endforeach
        </div>
        <div class="tab-pane fade show active users" role="tabpanel" aria-labelledby="tab-all" id="rank-all">
          @foreach($totalReputationRank as $index => $user)
            <div class="item-user">
              <span>{{ $index }}.</span>
              <img {{ avatarAttr($user) }}>
              <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
              <span class="reputation">{{ $user->reputation }}</span>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>