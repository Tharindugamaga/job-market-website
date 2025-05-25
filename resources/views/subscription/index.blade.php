@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @if (Session ::has ('message'))
            <div class="alert alert-warning"> {{Session::get('message')}}</div>
                
           
        @endif
        <div class="row">
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Weekly - $20</h5>
                        <p class="card-text">
                            Quick access for 7 days. Ideal for urgent hiring or testing the platform with minimal
                            commitment.
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Post up to 3 jobs</li>
                        <li class="list-group-item">Basic candidate search</li>
                        <li class="list-group-item">Email support</li>
                    </ul>
                    <div class="card-body text-center">
                        <a href="{{ route('pay.weekly') }}" class="card-link">
                            <button class="btn btn-success">pay</button>
                        </a>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Monthly - $80</h5>
                        <p class="card-text">
                            Flexible plan with full feature access for 30 days. Perfect for short-term recruitment or trial
                            periods.
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Up to 10 job postings</li>
                        <li class="list-group-item">Standard candidate visibility</li>
                        <li class="list-group-item">Email support</li>
                    </ul>
                    <div class="card-body text-center">
                        <a href="{{ route('pay.monthly') }}" class="card-link">
                            <button class="btn btn-success">pay</button>
                        </a>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Yearly - $200</h5>
                        <p class="card-text">
                            Full premium access for 12 months. Ideal for businesses with ongoing hiring needs and long-term
                            goals.
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Unlimited job postings</li>
                        <li class="list-group-item">Featured employer status</li>
                        <li class="list-group-item">Advanced candidate insights</li>
                    </ul>
                    <div class="card-body text-center">
                        <a href="{{ route('pay.yearly') }}" class="card-link">
                            <button class="btn btn-success">pay</button>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
