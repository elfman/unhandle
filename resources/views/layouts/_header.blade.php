<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a href="#" class="navbar-brand">Unhandle</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a href="#" class="nav-link">Home</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">Link</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        @guest
          <li class="nav-item"><a href="/login" class="nav-link">登录</a></li>
          <li class="nav-item"><a href="/register" class="nav-link">注册</a></li>
        @else
          <li class="nav-item dropdown" style="cursor: pointer;">
            <div class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              <span>
                <img {{ avatarAttr() }}
                     alt="{{ Auth::user()->name }}" class="avatar">
                <span>{{ Auth::user()->name }}</span>
              </span>
            </div>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">
                <span class="fa fa-user" aria-hidden="true"></span>
                个人中心
              </a>
              <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">
                <span class="fa fa-edit" aria-hidden="true"></span>
                编辑资料
              </a>
              <a class="dropdown-item" href="#" onclick="$('#logoutForm').submit()">
                <span class="fa fa-sign-out" aria-hidden="true"></span>
                退出登录
              </a>
              <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                {{ csrf_field() }}
              </form>
            </div>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>