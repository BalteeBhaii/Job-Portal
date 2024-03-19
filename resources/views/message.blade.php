@if(Session::has('successMessage'))
             <div class="alert alert-success">{{ Session::get('successMessage') }}</div>
@endif

@if(Session::has('errorMessage'))
  <div class="alert alet-danger">{{ Session::get('errorMessage') }}</div>
@endif


