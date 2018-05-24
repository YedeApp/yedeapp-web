<div class="list-group list-group-flush sidebar text-center">
  <a href="{{ route('user.edit', Auth::id()) }}" class="list-group-item list-group-item-action {{ active_class(if_route('user.edit')) }}"><i class="anticon icon-user"></i> 个人资料</a>
  <a href="{{ route('user.password', Auth::id()) }}" class="list-group-item list-group-item-action {{ active_class(if_route('user.password')) }}"><i class="anticon icon-key"></i> 修改密码</a>
</div>