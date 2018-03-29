@extends('layouts.app')

@section('title', $topic->title)

@section('content')
  {{-- Topic --}}
  @component('components.card')
    <div class="head clearfix">
      <h1 class="float-left">{{ $topic->title }}</h1>
      <div class="float-right">
        <div class="button"><a class="btn btn-light btn-sm" role="button"><svg class="icon" aria-hidden="true" title="收藏"><use xlink:href="#icon-hearto"></use></svg>收藏</a></div>
        <div class="button"><a class="btn btn-light btn-sm" role="button"><svg class="icon" aria-hidden="true" title="编辑"><use xlink:href="#icon-edit"></use></svg>编辑</a></div>
        <div class="button"><a class="btn btn-light btn-sm" role="button"><svg class="icon" aria-hidden="true" title="删除"><use xlink:href="#icon-delete"></use></svg>删除</a></div>
      </div>
    </div>
    <div class="body">{!! $topic->content !!}</div>
    <div class="sns">@include('topic._sns')</div>
    <div class="prev-next clearfix">
      @if ($prev)
        <a href="{{ route('topic.show', [$course, $prev]) }}" class="btn btn-light float-left prev" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="{{ $prev->title }}"><svg class="icon" aria-hidden="true" title="上一节"><use xlink:href="#icon-left"></use></svg>上一节</a>
      @endif
      @if ($next)
        <a href="{{ route('topic.show', [$course, $next]) }}" class="btn btn-light float-right next" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="{{ $next->title }}">下一节<svg class="icon ml-1 mr-0" aria-hidden="true" title="下一节"><use xlink:href="#icon-right"></use></svg></a>
      @endif
    </div>
  @endcomponent

  {{-- Comments --}}
  @component('components.card')
    <div class="clearfix">
      <div class="float-left">留言精选</div>
      <div class="float-right"><span class="jumper"><svg class="icon" aria-hidden="true" title="写留言"><use xlink:href="#icon-form"></use></svg>写留言</span></div>
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
                <a href="#" class="btn btn-light btn-sm" role="button"><svg class="icon" aria-hidden="true" title="回复"><use xlink:href="#icon-message1"></use></svg>回复</a>
              @endif
              @if ($can['delete-comment'])
                <a href="#" class="btn btn-light btn-sm" role="button"><svg class="icon" aria-hidden="true" title="删除"><use xlink:href="#icon-delete"></use></svg>删除</a>
              @endif
            </div>
            {{-- 原样输出评论有风险，在输入时就需要筛查 --}}
            <div class="content">{!! $comment->content !!}</div>
            <div class="created">{{ $comment->updated_at->diffForHumans() }}</div>
            {{-- 评论回复 --}}
            @foreach ($replies as $reply)
              <div class="reply media">
                <div class="media-body">
                  <div class="heading"><i class="v-line"></i>作者回复</div>
                  <div class="content">{!! $reply->content !!}</div>
                  <div class="created">{{ $comment->updated_at->diffForHumans() }}</div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach

      {{-- 订阅后才能留言 --}}
      <div class="post-reply media">
        <img class="avatar rounded-circle mr-3" src="{{ Auth::user()->avatar }}">
        <div class="media-body">
          <div>
            <form action="{{ route('comment.store') }}" method="post">
              {{ csrf_field() }}
              <input type="hidden" name="topic_id" value="{{ $topic->id }}">
              <input type="hidden" name="course_id" value="{{ $topic->course->id }}">
              <textarea name="content" class="editor form-control" placeholder="理性留言的你可以说是很有素质了" required></textarea>
              <button class="btn btn-primary btn-w-100" type="submit">提交</button><span class="tip">（快捷键 Ctrl + Enter）</span>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endcomponent
@endsection

@section('scripts')
<script>
// Variables
$editor = $('.post-reply .editor');

// Init prev and next popup tips
$(function () {
  $('[data-toggle="popover"]').popover()
})

// Jumper
$('.jumper').click(function() {
  $editor.focus();
})

</script>

{{-- Baidu sns-share --}}
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":["tqq","tieba","qzone","fbook","twi"],"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
@endsection
