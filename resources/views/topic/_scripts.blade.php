<script>
// Variables
var $editor = $('.post-reply .editor');
var $editorForm = $('.post-reply form');
var $jumper = $('#jumper');
var $btnConfirm = $('#modalConfirm .btn-confirm-yes');
var $btnCommentReply = $('.operations .btn-comment-reply');
var $btnCommentDelete = $('.operations .btn-comment-delete');
var $btnTopicDelete = $('.head .button .btn-topic-delete');

// Init prev and next popup tips
$(function () {
  $('[data-toggle="popover"]').popover()
})

// Only subscriber can do comments
if ($editor.length <= 0) {
    $jumper.popover();
}

// Jumper
$jumper.click(function() {
  $editor.focus();
})

// Ctrl + Enter submit
$editor.keydown(function(event) {
    if (event.ctrlKey && event.keyCode == 13) {
        $(this).parent('form').submit();
    }
});

// Prevent to submit multi-times
$editorForm.submit(function() {
  // if validated, do submit and set disabled status.
  if (this.reportValidity()) {
    $(this).children('button.btn').attr('disabled', 'disabled');
    $(this).children('.editor').off('keydown');
  } else {
    return false;
  }
})

// Call author reply editor
$btnCommentReply.click(function() {
  var $wrapper = $(this).parents('.media-body').find('.editor-wrapper');
  var isCollapsed = $(this).data('isCollapsed');

  if (isCollapsed) {
    $wrapper.find('.post-reply').remove();
    $(this).children('span').text('回复');
    $(this).data('isCollapsed', false);
  } else {
    var $cloneEditor = $('#reply-wrapper').children('.post-reply').clone({'withDataAndEvents':true});
    var $cloneForm = $cloneEditor.find('form');
    $cloneForm.children('.editor').val('');

    var id = $(this).attr('data');
    var $input = $('<input type="hidden" name="parent_id" value="' + parseInt(id) + '">');
    $input.appendTo($cloneForm);

    $cloneEditor.appendTo($wrapper);
    $(this).children('span').text('取消回复');
    $(this).data('isCollapsed', true);
  }
});

// Confirm modal
$('#modalConfirm').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var message = button.data('message');

  var modal = $(this);
  modal.find('.modal-body .message').text(message);
})

// Comment delete
$btnCommentDelete.click(function() {
  $btnConfirm.click(function() {
    $btnCommentDelete.parent('form').submit();
  })
})

// Topic delete
$btnTopicDelete.click(function() {
  $btnConfirm.click(function() {
    $btnTopicDelete.parent('form').submit();
  })
})
</script>