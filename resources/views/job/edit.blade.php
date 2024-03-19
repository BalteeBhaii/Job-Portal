@extends('layouts.admin.main')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-5">
            <h1>Update  a job</h1>
            @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            <form action="{{ route('job.update',[$listing->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Featured Image</label>
                    <input type="file" name="feature_image" id="featured_image" class="form-control" placeholder="Enter Featured Image">
                    @if($errors->has('featured_image'))
                    <div class="error">{{ $errors->first('featured_image') }}</div>
                    @endif
                </div>
                <div class="form-group">.
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control"  value="{{ $listing->title ?? '' }}">
                    @if($errors->has('title'))
                    <div class="error">{{ $errors->first('title') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="summernote" class="form-control">{{ $listing->description ?? '' }}</textarea>
                    @if($errors->has('description'))
                    <div class="error">{{ $errors->first('description') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="roles">Roles and Responsibility</label>
                    <textarea name="roles" id="summernote1" class="form-control">{{ $listing->roles ?? '' }}</textarea>
                    @if($errors->has('roles'))
                    <div class="error">{{ $errors->first('roles') }}</div>
                    @endif
                </div>
                <div class="form-group">

                    <label for="job_types">Job Types</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="job_type" value="Full Time" id="Fulltime" {{ $listing->job_type === 'Full Time' ? 'checked':'' }}>
                        <label for="fulltime" class="form-check-label">FullTime</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="job_type" value="Part Time" id="PartTime"{{ $listing->job_type === 'Part Time' ? 'checked':'' }}>
                        <label for="partTime" class="form-check-label">PartTime</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="job_type" value="Cascual" id="cascual" {{ $listing->job_type === 'Cascual' ? 'checked':'' }}>
                        <label for="cascual" class="form-check-label">Cascual</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="job_type" value="Contract" id="contract" {{ $listing->job_type === 'Contract' ? 'checked':'' }}>
                        <label for="contract" class="form-check-label">Contract</label>
                    </div>
                    @if($errors->has('job_type'))
                    <div class="error">{{ $errors->first('job_type') }}</div>
                    @endif
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ $listing->address ?? '' }}">
                        @if($errors->has('address'))
                    <div class="error">{{ $errors->first('address') }}</div>
                    @endif
                    </div>
                    <div class="form-group">
                        <label for="salary">Salary</label>
                        <input type="text" name="salary" id="salary" class="form-control" value="{{ $listing->salary ?? '' }}">
                        @if($errors->has('salary'))
                    <div class="error">{{ $errors->first('salary') }}</div>
                    @endif
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="text" name="date" id="datepicker" class="form-control" value="{{ $listing->application_close_date ?? '' }}">
                        @if($errors->has('date'))
                    <div class="error">{{ $errors->first('date') }}</div>
                    @endif

                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success">Update a job</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .note-insert{
        display:none!important;
    }
    .error{
        color:red;
        font-weight: bold;
    }
</style>
@endsection
