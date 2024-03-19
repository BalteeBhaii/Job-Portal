@extends('layouts.app')
@section('content')

<div class="container mt-5">
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    @if(Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif
    <div class="row justify-content-center">
        <form action="{{ route('user.update.profile') }}" method="POST" enctype="multipart/form-data">@csrf
            <div class="col-md-8">
                <div class="form-group">
                    <label for="name">Profile Image</label>
                    <input type="file" class="form-control" id="name" name="profile_pic">
                    @if(auth()->user()->profile_pic)
                    <img src="{{ Storage::url(auth()->user()->profile_pic) }}" alt="" width="150" class="mt-3">
                    @endif
                </div>
                <div class="form-group">
                    <label for="logo">Your Name</label>
                    <input type="text" class="form-control" name="name" value="{{ auth()->user()->name ?? '' }}">
                </div>
                <div class="form-group mt-5">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>

    <div class="row justify-content-center">

        <h1>Change your Password..</h1>
        <form action="{{ route('user.password') }}" method="POST" >@csrf
            <div class="col-md-8">
                <div class="form-group">
                    <label for="name">Your Current Password</label>
                    <input type="password" name="current_password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="logo">Your New Password</label>
                    <input type="text" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <label for="logo">Confirm Password</label>
                    <input type="text" class="form-control" name="password_confirmation">
                </div>
                <div class="form-group mt-5">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>

    <div class="row justify-content-center">
        <h1>Update your Resume..</h1>
        <form action="{{ route('upload.resume') }}" method="POST" enctype="multipart/form-data">@csrf

            <div class="col-md-8">
                <div class="form-group">
                    <label for="resume">Upload resume</label>
                    <input type="file" class="form-control" id="resume" name="resume">
                </div>
                <div class="form-group mt-5">
                    <button class="btn btn-success" type="submit">Upload</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
