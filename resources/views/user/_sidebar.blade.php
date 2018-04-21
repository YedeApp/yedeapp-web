<div class="list-group list-group-flush sidebar text-center">
  <a href="{{ route('user.edit', Auth::id()) }}" class="list-group-item list-group-item-action {{ active_class(if_route('user.edit')) }}"><svg class="icon" aria-hidden="true"><use xlink:href="#icon-user"></use></svg> 个人资料</a>
  <a href="{{ route('user.password', Auth::id()) }}" class="list-group-item list-group-item-action {{ active_class(if_route('user.password')) }}"><svg class="icon" aria-hidden="true"><use xlink:href="#icon-key"></use></svg> 修改密码</a>
</div>