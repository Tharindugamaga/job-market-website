@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- Success message for profile or password --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Error message --}}
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

   
              
            </ul>
        </div>
  

    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Profile Update Form --}}
            <div class="card mb-4">
                <div class="card-header">Update Profile</div>
                <div class="card-body">
                    <form action="{{ route('user.update.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="profile_pic">Profile Image</label>
                            <input type="file" class="form-control" id="profile_pic" name="profile_pic">
                            @if (auth()->user()->profile_pic)
                                <img src="{{ Storage::url(auth()->user()->profile_pic) }}" width="150" class="mt-3">
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">Your Name</label>
                            <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Password Change Form --}}
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
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>

<br>
            <div class="card">
                <div class="card-header">Update Your resume</div>
                <div class="card-body">
                    <form action="{{ route('upload.resume') }}" method="POST" enctype="multipart/form-data"> @csrf
                        @csrf
                        <div class="form-group mb-3">
                            <label for="resume">Upload your resume</label>
                            <input type="file" class="form-control" name="resume">
                        </div>
                        <div class="form-group mt-3 ">
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>
                        
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
