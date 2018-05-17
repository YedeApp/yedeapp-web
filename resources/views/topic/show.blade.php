@extends('layouts.app')

@section('title', $topic->title)

@section('content')

  {{-- Topic --}}
  @component('components.card')
    <div class="head clearfix">
      <div class="mb-2 clearfix">
        <h1 class="float-left">{{ $topic->title }}</h1>
        <div class="float-right">
          {{-- Login user can use the like function --}}
          {{-- @auth
            <div class="button"><a class="btn btn-light btn-sm btn-topic-like" role="button"><svg class="icon" aria-hidden="true" title="收藏"><use xlink:href="#icon-hearto"></use></svg>收藏</a></div>
          @endauth --}}

          {{-- User can delete and edit his/her own topic --}}
          @can('update', $topic)
            <div class="button"><a href="{{ route('topic.edit', $topic->id) }}" class="btn btn-light btn-sm btn-topic-edit" role="button"><svg class="icon" aria-hidden="true" title="编辑"><use xlink:href="#icon-edit"></use></svg>编辑</a></div>
            <div class="button">
              <form action="{{ route('topic.destroy', $topic->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <a class="btn btn-light btn-sm btn-topic-delete" role="button" data-toggle="modal" data-target="#modalConfirm" data-message="是否删除 {{ $topic->title }} ？"><svg class="icon" aria-hidden="true" title="删除"><use xlink:href="#icon-delete"></use></svg>删除</a>
              </form>
            </div>
          @endcan
        </div>
      </div>
      {{-- Breadcrumb --}}
      <div class="clearfix">@include('topic._breadcrumb')</div>
    </div>

    <div class="body markdown-body">{!! htmlspecialchars_decode($topic->content) !!}</div>
    {{--<div class="sns">@include('topic._sns')</div>--}}
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

@section('styles')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/mditor.min.css') }}">
@endsection

@section('scripts')
  {{-- Markdown parser --}}
  <script type="text/javascript"  src="{{ asset('js/mditor.min.js') }}"></script>
  <script>
    var HtmlUtil = {
      // 用正则表达式转码 html
      htmlEncodeByRegExp: function (str) {
        var s = "";

        if (str.length == 0) return "";

        s = str.replace(/&/g,"&amp;");
        s = s.replace(/</g,"&lt;");
        s = s.replace(/>/g,"&gt;");
        s = s.replace(/ /g,"&nbsp;");
        s = s.replace(/\'/g,"&#39;");
        s = s.replace(/\"/g,"&quot;");

        return s;
      },

      // 用正则表达式解码 html
      htmlDecodeByRegExp: function (str) {
          var s = "";

          if (str.length == 0) return "";

          s = str.replace(/&amp;/g,"&");
          s = s.replace(/&lt;/g,"<");
          s = s.replace(/&gt;/g,">");
          s = s.replace(/&nbsp;/g," ");
          s = s.replace(/&#39;/g,"\'");
          s = s.replace(/&quot;/g,"\"");

          return s;
      }
    };

    var $markdown = $('.markdown-body');
    var parser = new Mditor.Parser();
    var decodedHtml = HtmlUtil.htmlDecodeByRegExp($markdown.html());

    var topicHtml = parser.parse(decodedHtml);
    $markdown.html(topicHtml);
  </script>

  {{-- Comments scripts --}}
  @include ('topic._scripts')

  {{-- Baidu sns-share --}}
  {{--<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":["tqq","tieba","qzone","fbook","twi"],"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='https://ss1.baidu.com/9rA4cT8aBw9FktbgoI7O1ygwehsv/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>--}}

@endsection
