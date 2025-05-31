@extends('layouts.admin.main')

@section('content')
<div class="container mt-5">
    
    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Profile Update Form --}}
            <div class="card mb-4">
                <div class="card-header">Update Company Profile</div>
                <div class="card-body">
                    <form action="{{ route('user.update.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control" id="logo" name="profile_pic">
                            @if (auth()->user()->profile_pic)
                                <img src="{{ Storage::url(auth()->user()->profile_pic) }}" width="150" class="mt-3">
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">Company Name</label>
                            <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                        </div>

                        <button class="btn btn-success" type="submit">Update</button>
                    </form>
                </div>
            </div>

            {{-- Change Password Form --}}
            <div class="card">
                <div class="card-header">Change Password</div>
                <div class="card-body">
                    <form action="{{ route('user.password') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="current_password">Current Password</label>
                            <input type="password" class="form-control" name="current_password">
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>

                        <button class="btn btn-success" type="submit">Update Password</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
