<table class="table">
  <thead class="thead-light">
    <tr><th>最近订阅的课程</th></tr>
  </thead>
  <tbody>
    @forelse ($subscriptions as $subscription)
      <tr><td><span class="hint">订阅了</span><a href="{{ route('course.chapters', $subscription->course) }}" target="_blank">{{ $subscription->course->name }}</a></td></tr>
    @empty
    <tr><td class="text-center">目前没有内容</td></tr>
    @endforelse
  </tbody>
</table>

<table class="table">
  <thead class="thead-light">
    <tr><th>最近发表的留言</th></tr>
  </thead>
  <tbody>
    @include('user._part_of_comments')
  </tbody>
</table>