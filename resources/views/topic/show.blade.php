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
        <a href="#" class="btn btn-light float-left prev" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="test"><svg class="icon" aria-hidden="true" title="上一节"><use xlink:href="#icon-left"></use></svg>上一节</a>
        <a href="#" class="btn btn-light float-right next" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="test">下一节<svg class="icon ml-1 mr-0" aria-hidden="true" title="下一节"><use xlink:href="#icon-right"></use></svg></a>
    </div>
  @endcomponent

  {{-- Comments --}}
  @component('components.card')
    <div class="clearfix">
      <div class="float-left">留言精选</div>
      <div class="float-right"><span><svg class="icon" aria-hidden="true" title="写留言"><use xlink:href="#icon-form"></use></svg>写留言</span></div>
    </div>
    <div class="comments">
      <div class="comment media">
        <img class="avatar rounded-circle mr-3" src="https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png?imageView2/1/w/200/h/200">
        <div class="media-body">
          <div class="heading">凌小玲</div>
          <div class="operations"></div>
          <div class="content">一个公司的同事。可能因为都是单身，年纪相仿，就被其他同事开玩笑说在一起在一起，但其实我一点一点都不喜欢他，他也完全不是我喜欢的或可能会喜欢的类型，甚至不是99%以上女性喜欢的类型。</div>
          <div class="created">1个月前</div>
        </div>
      </div>

      <div class="comment media">
        <img class="avatar rounded-circle mr-3" src="https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png?imageView2/1/w/200/h/200">
        <div class="media-body">
          <div class="heading">凌小玲</div>
          <div class="content">一个公司的同事。可能因为都是单身，年纪相仿，就被其他同事开玩笑说在一起在一起，但其实我一点一点都不喜欢他，他也完全不是我喜欢的或可能会喜欢的类型，甚至不是99%以上女性喜欢的类型。</div>
          <div class="created">1个月前</div>
        </div>
      </div>

        <div class="comment media">
          <img class="avatar rounded-circle mr-3" src="https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png?imageView2/1/w/200/h/200">
          <div class="media-body">
            <div class="heading">凌小玲</div>
            <div class="content">一个公司的同事。可能因为都是单身，年纪相仿，就被其他同事开玩笑说在一起在一起，但其实我一点一点都不喜欢他，他也完全不是我喜欢的或可能会喜欢的类型，甚至不是99%以上女性喜欢的类型。</div>
            <div class="created">1个月前</div>
          </div>
        </div>

        <div class="reply media">
          <img class="avatar rounded-circle mr-3" src="https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png?imageView2/1/w/200/h/200">
          <div class="media-body">
            <div>
              <form action="#" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                <input type="hidden" name="course_id" value="">
                <textarea name="body" class="editor form-control" placeholder="理性留言的你可以说是很有素质了" required></textarea>
                <button class="btn btn-primary btn-w-100" type="submit">提交</button><span class="tip">（快捷键 Ctrl + Enter）</span>
              </form>
            </div>
          </div>
        </div>
    </div>
  @endcomponent
@endsection

@section('scripts')
  <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":["tqq","tieba","qzone","fbook","twi"],"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
@endsection
