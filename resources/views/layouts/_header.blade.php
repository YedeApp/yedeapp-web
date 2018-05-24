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
              <i class="anticon icon-user"></i>个人资料
            </a>
            <a class="dropdown-item" href="{{ route('user.edit', Auth::id()) }}">
              <i class="anticon icon-setting"></i>修改资料
            </a>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              <i class="anticon icon-export"></i>退出
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