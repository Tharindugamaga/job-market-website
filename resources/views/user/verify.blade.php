@extends('layouts.app')

@section('content')
<div class ='container'>
    <div class="row justify-content-center mt-5">
        <div class="card">
            <div class="card-header">Verify Account</div>
                <div class="card-body">
                    <p>Your account is not verified.please verify your account

                    <a href="{{ route('resend.email') }}" class="btn btn-danger">Resend verification email</a>

                    </p>
                

            </div>
        </div>
    </div>
</div>


@endsection