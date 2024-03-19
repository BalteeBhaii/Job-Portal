@extends('layouts.admin.main')
@section('content')
    <div class="container mt-5 ">

        @if(Session::has('success'))

        <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="row">
            <div class="col-md-8 mt-5">
                <h1>{{ $listing->title ?? '' }}</h1>
            </div>

            @foreach ($listing->users as $user)
                <div class="card mt-5 {{ $user->pivot->shortlisted ? 'card-bg' : '' }}">
                    <div class="row g-0">
                        <div class="col-auto">
                            @if ($user->profile_pic)
                                <img src="{{ Storage::url($user->profile_pic) }}" alt="" class="rounded-circle"
                                    style="width: 150px">
                            @else
                                <img src="https://placehold.co/400 " alt="" class="rounded-circle"
                                    style="width: 150px">
                            @endif
                        </div>
                        <div class="col-auto">
                            <div class="card-body">
                                <p class="fw-bold">{{ $user->name }}</p>
                                <p class="card-text">{{ $user->email }}</p>
                                <p class="card-text">{{ $user->pivot->created_at->format('Y-m-d') }}</p>
                            </div>
                        </div>
                        <div class="col-auto align-self-center">
                            <form action="{{ route('applicants.shortlist',[$listing->id, $user->id]) }}" method="post">
                                @csrf
                            <a href="{{ Storage::url($user->resume) }}" target="_blank" class="btn btn-primary">Download Resume</a>
                            <button type="submit" class="btn {{ $user->pivot->shortlisted ? 'btn-success' : 'btn-dark ' }}">{{ $user->pivot->shortlisted ? 'Shortlisted' : 'Shortlist' }} </button>
                        </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <style>
        .card-bg{
            background: green;
        }
    </style>
@endsection
