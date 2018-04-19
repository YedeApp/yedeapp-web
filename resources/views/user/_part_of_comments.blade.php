@forelse ($comments as $comment)
  @php
    $href = jumpToComment($comment, $comment->course->slug);
  @endphp
  <tr>
    <td>
      <span class="hint">发表了</span>
      <a href="{{ $href }}" target="_blank">{{ truncate($comment->content, 50) }}</a>
      <span class="hint">位于</span>
      <a href="{{ $href }}" target="_blank">{{ truncate($comment->topic->title, 35) }}</a>
      <span class="datetime float-right">{{ $comment->created_at->diffForHumans() }}</span>
    </td>
  </tr>
@empty
  <tr>
    <td class="text-center">目前没有内容</td>
  </tr>
@endforelse