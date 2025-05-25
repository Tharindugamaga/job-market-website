@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1>Looking for a Job</h1>
            <h3>Please create an Account</h3>
            <img src="{{ asset('images/OIP.webp') }}" alt="Job Seeker" class="img-fluid rounded">
        </div>

        <div class="col-md-6">
            <div class="card" id="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form method="POST" id="registerForm">
                        @csrf

                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter your full name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter Email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter Password" required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <br>
                        <button type="submit" class="btn btn-primary" id="btnRegister">Register</button>
                    </form>
                </div>
            </div>
            <div id="message" class="mt-3"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const url = "{{ route('store.Seeker') }}";
    const form = document.getElementById("registerForm");
    const button = document.getElementById("btnRegister");
    const messageDiv = document.getElementById("message");
    const card = document.getElementById("card");

    button.addEventListener("click", function(event) {
        event.preventDefault();

        messageDiv.innerHTML = '';
        const formData = new FormData(form);

        button.disabled = true;
        button.innerHTML = 'Sending email...';

        fetch(url, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(async response => {
            const contentType = response.headers.get("content-type");

            if (!response.ok) {
                if (contentType && contentType.includes("application/json")) {
                    const errorData = await response.json();
                    throw errorData;
                } else {
                    const errorText = await response.text();
                    throw new Error("Server Error: " + errorText.substring(0, 100));
                }
            }

            return response.json();
        })
        .then(data => {
            button.innerHTML = 'Register';
            button.disabled = false;
            messageDiv.innerHTML = '<div class="alert alert-success">Registration successful. Please check your email to verify it.</div>';
            card.style.display = 'none';
        })
        .catch(error => {
            button.innerHTML = 'Register';
            button.disabled = false;

            if (error.errors) {
                let messages = Object.values(error.errors).flat().join('<br>');
                messageDiv.innerHTML = `<div class="alert alert-danger">${messages}</div>`;
            } else {
                messageDiv.innerHTML = `<div class="alert alert-danger">${error.message || 'Something went wrong.'}</div>`;
                console.error(error);
            }
        });
    });
});
</script>
@endsection
