@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row justify-content-center mt-2">
        <div class="col">
            <div class="hero-section bg-light rounded" style="height:200px;">
                <!-- You can add a banner image or gradient background -->
            </div>
        </div>
    </div>

    <!-- Company Info -->
    <div class="row mt-5">
        <div class="col d-flex align-items-center gap-3">
            <img src="{{ asset('storage/' . $company->logo ?? 'default-logo.png') }}" alt="Company Logo" class="img-thumbnail" width="80">
            <div>
                <h2 class="mb-1">{{ $company->name }}</h2>
                <p class="mb-0">{{ $company->address }}</p>
            </div>
        </div>
    </div>

    <!-- Company Description -->
    <div class="row mt-4">
        <div class="col">
            <h4>About Us</h4>
            <p>{{ $company->about }}</p>
        </div>
    </div>

    <!-- Job Listings -->
    <div class="row mt-5">
        <div class="col-md-8">
            <h4>Open Positions</h4>

            @forelse ($company->jobs as $job)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $job->title }}</h5>
                        <p class="card-text"><strong>Location:</strong> {{ $job->address }}</p>
                        <p class="card-text"><strong>Salary:</strong> {{ ($job->salary) }} LKR per year</p>
                <a href="{{ route('job.show',[$job->slug]) }}" class="btn btn-dark">View Details</a>
                    </div>
                </div>
            @empty
                <p>No jobs available at this time.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
