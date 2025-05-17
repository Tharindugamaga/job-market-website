@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            @auth
                {{ auth()->user()->name }}
                {{ auth()->user()->email }}
            @else
            @endauth
        </div>
    </div>
@endsection
