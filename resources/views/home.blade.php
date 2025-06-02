@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="d-flex justify-content-between">
                <h4>Recommended job</h4>
                <div class="dropdown">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Salary
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item"
                                href="{{ route('listing.index', ['sort' => 'salary_high_to_low']) }}">High
                                to low</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('listing.index', ['sort' => 'salary_low_to_high']) }}">Low
                                to High</a></li>

                    </ul>
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Date
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('listing.index', ['date' => 'latest']) }}">latest</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('listing.index', ['date' => 'oldest']) }}">Oldest
                            </a></li>

                    </ul>
                      <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                       Job type
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('listing.index', ['job_type' => 'Fulltime']) }}">Full Time</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('listing.index', ['job_type' => 'Parttime']) }}">Part Time</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('listing.index', ['job_type' => 'Casual']) }}">Casual</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('listing.index', ['job_type' => 'Contract']) }}">Contract</a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="row mt-2 g-1">
                @foreach ($jobs as $job)
                    <div class="col-md-3">
                        <div class="card p-2 {{ $job->job_type}}">
                            <div class="text-right"><small class="badge text-bg-info">{{ $job->job_type }}</small></div>
                            <div class="text-center mt-2 p-3">
                                <img src="{{ Storage::url($job->profile->profile_pic) }}" alt="" width="100"
                                    class="rounded-circle" /><br> <br>
                                <span class="d-block font-weight-bold">{{ $job->title }}</span>
                                <hr> <span>{{ $job->profile->name }}</span>
                                <div class="d-flex flex-row align-otems-center justify-content-center">
                                    <small class="ml-1">{{ $job->address }}</small>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <span>{{ $job->salary }}</span>
                                    <a href="{{ route('job.show', [$job->slug]) }}"><button
                                            class="btn btn-sm btn-outline-dark ">Apply</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
    <style>
        .Fulltime {
            background-color: #d1e7dd;
        }
        .Parttime {
            background-color: #fff3cd;
        }
        .Casual {
            background-color: #f8d7da;
        }
        .Contract {
            background-color: #d1ecf1;
        }
    </style>
@endsection
