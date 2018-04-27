@extends('layouts.app')

@section('title', $course->name)

@section('content')
  @component('components.card')

    {{-- Head --}}
    <div class="head">
      <svg class="icon" aria-hidden="true"><use xlink:href="#icon-shoppingcart"></use></svg> 订阅课程
    </div>

    {{-- Body --}}
    <div class="body table-responsive">
      <table class="table purchase-info ">
        <tr>
          <td class="caption">订单号</td>
          <td class="item">{{ $qrid }}</td>
        </tr>
        <tr>
          <td class="caption">课程名</td>
          <td class="item">{{ $course->name }}</td>
        </tr>
        <tr>
          <td class="caption">价格</td>
          <td class="item"><span class="price">{{ $course->getPriceForHumans() }}</span> 元</td>
        </tr>
        <tr>
          <td class="caption">支付方式</td>
          <td class="item">微信 / 支付宝</td>
        </tr>
        <tr>
          <td class="caption">扫码支付</td>
          <td><img id="payment-qrcode" src="{{ $qrcode }}"></td>
        </tr>
        <tr>
          <td class="caption">注意事项</td>
          <td class="item">
            <p>1. 支付过程中请不要跳转和关闭本页面，支付完成后页面会自动跳转；</p>
            <p>2. 如果支付完成，页面没有跳转，请点击 <a id="btnIHadPaid" href="#">已完成付款</a> 系统会再次确认；</p>
            <p>3. 如果你已支付，但课程没有开通，请添加微信公众号：野得公号（公众号ID：yedeapp），发送你的用户名 + 订单号 + 遇到的问题，我们会帮你处理。</p>
          </td>
        </tr>
      </table>
    </div>

  @endcomponent
@endsection

@section('scripts')
<script>
var paymentCheckUrl = "{{ route('course.pull') }}";
var paymentCheckData = { qrid: '{{ $qrid }}' };
var redirectUrl = "{{ route('course.chapters', $course) }}";
var times = 0;
var maxTimes = 60;

var checkPayment = function() {
  $.get(paymentCheckUrl, paymentCheckData, function(data) {
    if (data == 1) {
      window.location.href = redirectUrl;
    }
  });
}

var timer = setInterval(function() {
  if (times < maxTimes) {
    checkPayment();
    times++;
  } else {
    clearInterval(timer);
  }
}, 2000);

$(document).ready(function() {
  $('#btnIHadPaid').click(function() {
    checkPayment();
    alert('正在为您查询支付信息');
  });
});
</script>
@endsection