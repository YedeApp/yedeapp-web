@component('components.card')
  <div class="clearfix">
    <div class="float-left">留言精选</div>
    <div class="float-right"><a id="jumper" data-trigger="hover" data-placement="top" data-content="留言请先订阅"><svg class="icon" aria-hidden="true" title="写留言"><use xlink:href="#icon-form"></use></svg>写留言</a></div>
  </div>
  <div class="comments">
    @foreach ($comments as $comment)
      <div class="comment media">
        <a id="comment_{{ $comment->id }}"></a>
        <img class="avatar rounded-circle mr-3" src="{{ $comment->user->avatar }}">
        <div class="media-body">
          <div class="heading">{{ $comment->user->name }}</div>
          <div class="operations">
            @if ($can['reply-comment'])
              <a class="btn btn-light btn-sm btn-reply" role="button" data="{{ $comment->id }}"><svg class="icon" aria-hidden="true" title="回复"><use xlink:href="#icon-message1"></use></svg><span>回复</span></a>
            @endif
            @if ($can['delete-comment'])
              <a class="btn btn-light btn-sm btn-delete" role="button"><svg class="icon" aria-hidden="true" title="删除"><use xlink:href="#icon-delete"></use></svg><span>删除</span></a>
            @endif
          </div>
          {{-- 原样输出评论有风险，在输入时就需要筛查 --}}
          <div class="content">{!! $comment->content !!}</div>
          <div class="created">{{ $comment->updated_at->diffForHumans() }}</div>
          <div class="editor-wrapper"></div>
          {{-- 评论回复 --}}
          @foreach ($replies as $reply)
            @if ($reply->parent_id == $comment->id)
              <div class="reply media">
                <a id="comment_{{ $reply->id }}"></a>
                <div class="media-body">
                  <div class="heading"><i class="v-line"></i>作者回复</div>
                  <div class="content">{!! $reply->content !!}</div>
                  <div class="created">{{ $comment->updated_at->diffForHumans() }}</div>
                </div>
              </div>
            @endif
          @endforeach
        </div>
      </div>
    @endforeach

    {{-- 订阅后才能留言 --}}
    @can ('show', $course)
      <div id="reply-wrapper">
        <div class="post-reply media">
          <img class="avatar rounded-circle mr-3" src="{{ Auth::user()->avatar }}">
          <div class="media-body">
            <div>
              <form action="{{ route('comment.store') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <textarea name="content" class="editor form-control" placeholder="理性留言的你可以说是很有素质了" required minlength="2" maxlength="1000"></textarea>
                <button class="btn btn-primary btn-w-100" type="submit">提交</button><span class="tip">（快捷键 Ctrl + Enter）</span>
              </form>
            </div>
          </div>
        </div>
      </div>
    @else
      <div class="text-center my-3"><a href="#">留言请先订阅</a></div>
    @endcan
  </div>
@endcomponent