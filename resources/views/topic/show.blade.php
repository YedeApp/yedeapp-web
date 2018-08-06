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
            <div class="button"><a class="btn btn-light btn-sm btn-topic-like" role="button"><i class="anticon icon-hearto"></i>收藏</a></div>
          @endauth --}}

          {{-- User can delete and edit his/her own topic --}}
          @can('update', $topic)
            <div class="button"><a href="{{ route('topic.edit', $topic->id) }}" class="btn btn-light btn-sm btn-topic-edit" role="button"><i class="anticon icon-edit"></i>编辑</a></div>
            <div class="button">
              <form action="{{ route('topic.destroy', $topic->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <a class="btn btn-light btn-sm btn-topic-delete" role="button" data-toggle="modal" data-target="#modalConfirm" data-message="是否删除 {{ $topic->title }} ？"><i class="anticon icon-delete"></i>删除</a>
              </form>
            </div>
          @endcan
        </div>
      </div>
      {{-- Breadcrumb --}}
      <div class="clearfix">@include('topic._breadcrumb')</div>
    </div>

    <div class="body markdown-body">
      {!! markdown($topic->content) !!}
    </div>
    {{--<div class="sns">@include('topic._sns')</div>--}}
    <div class="prev-next clearfix">
      @if ($prev)
        <a href="{{ route('topic.show', [$course, $prev]) }}" class="btn btn-light float-left prev" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="{{ $prev->title }}"><i class="anticon icon-left"></i>上一节</a>
      @endif
      @if ($next)
        <a href="{{ route('topic.show', [$course, $next]) }}" class="btn btn-light float-right next" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="{{ $next->title }}">下一节<i class="anticon icon-right"></i></a>
      @endif
    </div>
  @endcomponent

  {{-- Comments --}}
  @include ('topic._comments')
@endsection

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/mditor.min.css') }}">
@endsection

@section('scripts')
  {{-- Mditor parser --}}
  <script src="{{ asset('js/mditor.min.js') }}"></script>

  {{-- Comments scripts --}}
  @include ('topic._scripts')

  {{-- Baidu sns-share --}}
  {{--<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":["tqq","tieba","qzone","fbook","twi"],"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='https://ss1.baidu.com/9rA4cT8aBw9FktbgoI7O1ygwehsv/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>--}}
@endsection
