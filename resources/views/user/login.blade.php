@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            

            <div class="col-md-8">
                <div class="card shadow -lg">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form action="{{ route('login.post') }}" method="post">
                            @csrf

                          

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password">
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                           
                            <br>
                           <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Login</button>
                           </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
