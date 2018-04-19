<header>
  <div class="container">
    <a class="logo" href="{{ route('home') }}"><img src="/images/yede_header_logo.png" alt="野得APP"></a>
    <ul class="info">
      @guest
        <li class="link login"><a href="{{ route('login') }}">登录</a></li>
        <li class="link register"><a href="{{ route('register') }}">注册</a></li>
      @else
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            <span class="avatar"><img src="{{ Auth::user()->avatar }}" class="img-fluid" width="30px" height="30px"></span>
            <span class="username">{{ Auth::user()->name }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('user.show', Auth::id()) }}">
              <svg class="icon button-icon" aria-hidden="true"><use xlink:href="#icon-user"></use></svg>个人资料
            </a>
            <a class="dropdown-item" href="{{ route('user.edit', Auth::id()) }}">
              <svg class="icon button-icon" aria-hidden="true"><use xlink:href="#icon-setting"></use></svg>修改资料
            </a>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              <svg class="icon button-icon" aria-hidden="true"><use xlink:href="#icon-export"></use></svg>退出
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
          </ul>
        </li>
      @endguest
    </ul>
  </div>
</header>