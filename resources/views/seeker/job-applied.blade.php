@extends('layouts.app')
@section('content')

<div class="container mt-5">
    <div class="row mt-5">
        <div class="col-md-8">
          <h3>List of Jobs</h3>

          @foreach ($users as $user )

          @foreach ($user->listings as $job )+

          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title"> {{  $job->title }}</h5>
              <p class="card-text">Applied: {{ $job->pivot->created_at }}</p>
              <a href="{{ route('job.show',[$job->slug]) }}" class="btn btn-primary">View</a>
            </div>
          </div>
          @endforeach

          @endforeach

        </div>
      </div>
    </div>

</div>

@endsection
