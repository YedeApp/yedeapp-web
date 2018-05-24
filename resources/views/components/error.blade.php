@if (count($errors) > 0)
  <div class="alert alert-danger" role="alert">
    <h5>抱歉，无法完成操作：</h5>
    <ul class="pl-2">
      @foreach ($errors->all() as $error)
        <li><i class="anticon icon-warning"></i> {{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif