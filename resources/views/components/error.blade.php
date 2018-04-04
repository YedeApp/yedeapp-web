@if (count($errors) > 0)
  <div class="alert alert-danger mt-3" role="alert">
    <h5>抱歉，无法完成操作：</h5>
    <ul class="pl-2">
      @foreach ($errors->all() as $error)
        <li><svg class="icon" aria-hidden="true"><use xlink:href="#icon-closecircleo"></use></svg> {{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif