@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <img src="{{ Storage::url($listing->feature_image) }}" class="card-img-top" alt="Cover Image"
                        style="height: 250px; object-fit: cover;">
                    <div class="card-body">

                        <a href="{{ route('company',[$listing->profile->id]) }}">
                            <img src="{{ Storage::url($listing->profile->profile_pic) }}" width="60" class="rounded-circle">
                        </a>
                        <b>{{$listing->profile->name}}</b>


                        <h2 class="card-title">{{ $listing->title }}</h2>

                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        <span class="badge bg-primary">{{ $listing->job_type }}</span>
                        <p><b>Salary:</b> {{ $listing->salary }}</p>
                        <p><b>Address:</b> {{ $listing->address }}</p>
                        <h4 class="mt-4"><b>Description:</b> <br><br>{!! $listing->description !!}</h4>
                        <hr>
                        <h4><b>Roles and Responsibilities</b></h4>
                        {!! $listing->roles !!}
                        <p class="card-text mt-4"><b>Application closing date:</b> {{ $listing->application_close_date }}
                        </p>

                        @auth
                            @if (optional(auth()->user()->profile)->resume)
                                <!-- Show Apply Now button if resume exists -->
                                <form action="{{ route('applicantion.submit', [$listing->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary mt-3">Apply Now</button>
                                </form>
                            @else
                                <!-- Show resume upload modal trigger -->
                                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                                    data-bs-target="#resumeModal">
                                    Apply
                                </button>
                            @endif
                        @else
                            <!-- Show login button if guest -->
                            <a href="{{ route('login') }}" class="btn btn-outline-primary mt-3">Login to Apply</a>
                        @endauth

                        <!-- Resume Upload Modal -->
                        <div class="modal fade" id="resumeModal" data-bs-backdrop="static" tabindex="-1"
                            aria-labelledby="resumeModalLabel" aria-hidden="true">
                            <form action="{{ route('applicantion.submit', [$listing->id]) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="resumeModalLabel">Upload Resume</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="file" name="file" id="fileUpload" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" id="btnApply" disabled>
                                                Apply
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- End Modal -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include FilePond JS and CSS -->
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <script>
        const inputElement = document.querySelector('input[id="fileUpload"]');
        const pond = FilePond.create(inputElement);

        pond.setOptions({
            server: {
                url: '/resume/upload',
                process: {
                    method: 'POST',
                    withCredentials: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    ondata: (formData) => {
                        const file = pond.getFiles()[0]?.file;
                        if (file) {
                            formData.append('file', file, file.name);
                        }
                        return formData;
                    },
                    onload: (response) => {
                        document.getElementById('btnApply').removeAttribute('disabled');
                    },
                    onerror: (error) => {
                        console.log('Upload error:', error);
                    }
                },
            },
        });
    </script>
@endsection
