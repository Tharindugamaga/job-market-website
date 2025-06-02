@extends('layouts.admin.main')

@section('content')
    <div class="container mt-5">
        <div class="col-md-10 mx-auto">
            <div class="row mb-4">
                <h1 class="fw-bold">{{ $listing->title }}</h1>
                @if(Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
            </div>

            @foreach ($listing->users as $user)
                <div class="card mb-4 shadow-sm p-3 d-flex flex-row align-items-center justify-content-between {{ $user->pivot->shortlisted ? 'card-bg' : '' }}">
                    
                    {{-- Image Box --}}
                    <div class="profile-image-box me-4">
                        @if ($user->profile_pic && Storage::exists($user->profile_pic))
                            <img src="{{ Storage::url($user->profile_pic) }}" alt="Profile Picture" class="profile-pic">
                        @else
                            <img src="https://placehold.co/150x150" alt="Default Profile Picture" class="profile-pic">
                        @endif
                    </div>

                    {{-- User Info --}}
                    <div class="flex-grow-1">
                        <p class="fw-bold mb-1 fs-5">{{ $user->name }}</p>
                        <p class="text-muted mb-1">{{ $user->email }}</p>
                        <p class="text-muted small mb-0">Applied on: {{ $user->pivot->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>

                    {{-- Buttons --}}
                    <form action="{{ route('applicants.shortlist', [$listing->id, $user->id]) }}" method="POST" class="d-flex flex-column gap-2">
                        @csrf
                        <a href="{{ Storage::url($user->resume) }}" class="btn btn-primary" target="_blank">Download Resume</a>
                        <button type="submit"
                                class="{{ $user->pivot->shortlisted ? 'btn btn-success' : 'btn btn-dark' }}">
                            {{ $user->pivot->shortlisted ? 'Shortlisted' : 'Shortlist' }}
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .card-bg {
            background-color: #d4edda !important;
        }

        .profile-image-box {
          
            border-radius: 12px;
        }

        .profile-pic {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            display: block;
        }

        @media (max-width: 768px) {
            .card.d-flex {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            form.d-flex {
                flex-direction: column;
                align-items: center;
                margin-top: 1rem;
            }

            .profile-image-box {
                margin-bottom: 1rem;
            }
        }
    </style>
@endsection
