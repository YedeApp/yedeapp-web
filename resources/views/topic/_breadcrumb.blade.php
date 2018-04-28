<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">首页</a></li>
    <li class="breadcrumb-item"><a href="{{ route('course.chapters', $course) }}">{{ $course->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $topic->title }}</li>
  </ol>
</nav>