<table class="table">
  <tbody>
    @include('user._part_of_comments')
  </tbody>
</table>
@empty(!$comments)
  <div class="d-flex justify-content-center">
    {{ $comments->links() }}
  </div>
@endempty