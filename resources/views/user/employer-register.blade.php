@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h1>Looking for an employee?</h1>
            <h3>Please create an account</h3>
            <img src="{{ asset('images/register.png') }}" alt="">
        </div>

        <div class="col-md-6">
            <div class="card" id="card">
                <div class="card-header">Employer Registration</div>
                <form action="{{ route('create.employer') }}" method="post" id="registrationForm">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Company Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <br>
                        <div class="form-group">
                            <button id="btnRegister" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="message"></div>
        </div>
    </div>
</div>

<script>
    document.getElementById('btnRegister').addEventListener('click', function(event) {
        event.preventDefault();

        var form = document.getElementById('registrationForm');
        var messageDiv = document.getElementById('message');
        messageDiv.innerHTML = '';
        var card = document.getElementById('card');
        var formData = new FormData(form);
        var url = form.getAttribute('action');

        var button = event.target;
        button.disabled = true;
        button.innerHTML = 'Sending Email...';

        fetch(url, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Network response was not ok');
            }
        })
        .then(data => {
            button.innerHTML = "Submit";
            button.disabled = false;
            messageDiv.innerHTML = '<div class="alert alert-success">Registration was successful. Please check your email.</div>';
            card.style.display = 'none';
        })
        .catch(error => {
            console.error('Error during fetch:', error);
            button.innerHTML = "Submit";
            button.disabled = false;
            messageDiv.innerHTML = '<div class="alert alert-danger">Something went wrong. Please try again.</div>';
        });
    });
</script>
@endsection
