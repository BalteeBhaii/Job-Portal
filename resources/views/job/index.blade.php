@extends('layouts.admin.main')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <h1>All jobs</h1>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Your Jobs
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Created On</th>
                            <th>Edit</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Title </th>
                            <th>Created On</th>
                            <th>Edit</th>
                            <th>Date</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($jobs as $job )

                        <tr>
                            <td>{{ $job->title ?? '' }}</td>
                            <td>{{ $job->created_at->format('Y-m-d ') ?? '' }}</td>
                            <td><a href="{{ route('job.edit',[$job->id]) }}">Edit</td> </a>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $job->id }}">Delete</a></td>
                        </tr>

                        <!-- Modal -->

                        <div class="modal fade" id="deleteModal{{ $job->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <form action="{{ route('job.delete',[$job->id]) }}" method="POST">@csrf
                                @method('DELETE')
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="deleteModal">Confirmation Delete</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Save Changes </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
