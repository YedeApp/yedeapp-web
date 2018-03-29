<script>
// Variables
var $editor = $('.post-reply .editor');
var $btnSubmit = $('.post-reply').find('button.btn');

// Init prev and next popup tips
$(function () {
  $('[data-toggle="popover"]').popover()
})

// Jumper
$('.jumper').click(function() {
  $editor.focus();
})

// Ctrl + Enter submit
$editor.keydown(function(event) {
    if (event.ctrlKey && event.keyCode == 13) {
        $(this).parent('form').submit();
        // Prevent to submit multi-times
        $(this).off('keydown').siblings('button.btn').attr('disabled', 'disabled');
    }
});

// Reply submit
$btnSubmit.click(function() {
    $(this).parent('form').submit();
    // Prevent multi-clicking
    $(this).attr('disabled', 'disabled').siblings('.editor').off('keydown');
});
</script>