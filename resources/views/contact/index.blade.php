
<h1>List of user</h1>


@foreach ($contacts  as $user )

  <p> {{ $user->name ?? '' }}</p>
@endforeach
