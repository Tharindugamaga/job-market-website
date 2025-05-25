@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1>Looking for an employee?</h1>
                <h3>Please create an Account</h3>
                <img src="{{ asset('images/OIP.webp') }}" alt="Job Seeker" class="img-fluid rounded">
            </div>

            <div class="col-md-6">
                <div class="card" id="card">
                    <div class="card-header">Employer Registration</div>
                    <div class="card-body">
                        <form action="#" method="post" id="registerForm">
                            @csrf

                            <div class="form-group">
                                <label for="name">Company Name</label>
                                <input type="text" name="name" id="name"
                                    class="form-control  @error('name') is-invalid @enderror"
                                    placeholder="Enter your full name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email"
                                    value="{{ old('email') }}" required>
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
        var url = "{{ route('store.employer') }}";
        document.getElementById("btnRegister").addEventListener("click", function(event) {
            event.preventDefault();

            var form = document.getElementById("registerForm");
            var card = document.getElementById("card");
            var messageDiv = document.getElementById('message');
            messageDiv.innerHTML = '';
            var formData = new FormData(form);

            var button = event.target;
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
                    if (!response.ok) {
                        const contentType = response.headers.get("content-type");
                        if (contentType && contentType.includes("application/json")) {
                            const errorData = await response.json();
                            throw errorData;
                        } else {
                            throw new Error("Unexpected response from server");
                        }
                    }
                    return response.json();
                })
                .then(data => {
                    button.innerHTML = 'Register';
                    button.disabled = false;
                    messageDiv.innerHTML =
                        '<div class="alert alert-success">Registration successful. Please check your email to verify it.</div>';
                    card.style.display = 'none';
                })
                .catch(error => {
                    button.innerHTML = 'Register';
                    button.disabled = false;

                    if (error.errors) {
                        let messages = Object.values(error.errors).flat().join('<br>');
                        messageDiv.innerHTML = `<div class="alert alert-danger">${messages}</div>`;
                    } else {
                        messageDiv.innerHTML =
                            `<div class="alert alert-danger">${error.message || 'Something went wrong.'}</div>`;
                        console.error(error);
                    }
                });

        });
    </script>
@endsection
