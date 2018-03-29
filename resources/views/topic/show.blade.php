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
  @include ('topic._comments')
@endsection

@section('scripts')
  {{-- Comments scripts --}}
  @include ('topic._scripts')

  {{-- Baidu sns-share --}}
  <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":["tqq","tieba","qzone","fbook","twi"],"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
@endsection
