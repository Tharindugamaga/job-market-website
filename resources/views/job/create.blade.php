@extends('layouts.admin.main')

@section('content')
    <div class="container mt-5">

        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <h1>Post a job</h1>
                <form action="{{ route('job.store') }}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="from-group">
                        <label for="title">Feature Image:</label>
                        <input type="file" name="feature_image" class="form-control" id="feature_image">
                     @if ($errors->has('feature_image'))
                            <div class="text-danger">{{ $errors->first('feature_image') }}</div>
                        @endif
                    </div>
                    <div class="from-group">
                        <label for="title">Job Title:</label>
                        <input type="text" name="title" class="form-control" id="title"
                            placeholder="Enter job title">
                        @if ($errors->has('title'))
                            <div class="text-danger">{{ $errors->first('title') }}</div>
                        @endif
                    </div>
                    <div class="from-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control summernote" name="description" id="description"></textarea>
                    @if ($errors->has('description'))
                            <div class="text-danger">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                    <div class="from-group">
                        <label for="roles">Roles and Responsibility:</label>
                        <textarea class="form-control summernote" id="roles" name="roles"></textarea>

                    @if ($errors->has('roles'))
                            <div class="text-danger">{{ $errors->first('roles') }}</div>
                        @endif
                    </div>
                    <div class="from-group">
                        <label>Job types:</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="job_type" id="Fulltime" value="Fulltime">
                            <label for="Fulltime" class="form-check-label">Full Time</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="job_type" id="Parttime" value="Parttime">
                            <label for="Parttime" class="form-check-label">Part Time</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="job_type" id="Casual" value="Casual">
                            <label for="Casual" class="form-check-label">Casual</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="job_type" id="Contract" value="Contract">
                            <label for="Contract" class="form-check-label">Contract</label>
                        </div>
                         @if ($errors->has('job_type'))
                            <div class="text-danger">{{ $errors->first('job_type') }}</div>
                        @endif
                    </div>
                    <div class="from-group">
                        <label for="address">Address:</label>
                        <input type="text" name="address" class="form-control" id="address">
                      @if ($errors->has('address'))
                            <div class="text-danger">{{ $errors->first('address') }}</div>
                        @endif
                    </div> 
                     <div class="from-group">
                        <label for="salary">Salary:</label>
                        <input type="text" name="salary" class="form-control" id="salary">
                      @if ($errors->has('salary'))
                            <div class="text-danger">{{ $errors->first('salary') }}</div>
                        @endif
                    </div> 
                    <div class="from-group">
                        <label for="date">Application closing date:</label>
                        <input type="text" name="date" class="form-control" id="datepicker">
                    @if ($errors->has('date'))
                            <div class="text-danger">{{ $errors->first('date') }}</div>
                        @endif
                    </div>
                    <div class="from-group mt-4 ">
                        <button type="submit" class="btn btn-success">Post a Job</button>

                    </div>

                </form>
            </div>
        </div>

    </div>

    <style>
        .note-insert {
            display: none;
        }

        .text-danger {
            font-family: Arial, sans-serif;
            font-weight: 700 !important;
            color: red;
        }
    </style>
@endsection
