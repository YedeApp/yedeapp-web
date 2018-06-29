{!! showSessionMessage('message') !!}
{!! showSessionMessage('success') !!}
{!! showSessionMessage('danger') !!}
{!! showSessionMessage('status') !!}

<script>
var closeAlertMessage = setTimeout(function () {
  $('.alert-dismissible').alert('close')
}, 3000);
</script>