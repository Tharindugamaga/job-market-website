<?php

namespace App\Http\Controllers;

use App\Http\Middleware\isPremiumUser;
use App\Http\Requests\JobEditFormRequest;
use Illuminate\Http\Request;
use App\Models\Listing;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Requests\JobPostFormRequest;
use App\Post\JobPost;
use Illuminate\Contracts\Queue\Job;

class PostJobController extends Controller
{

  protected $job;

  public function __construct(JobPost $job)
  {
    $this->job = $job;
    $this->middleware('auth');
    $this->middleware(isPremiumUser::class)->only(['create', 'store' ]);
  }

  public function index()
  {
    $jobs = Listing::where('user_id',auth()->user()->id)->get();
     return view('job.index',compact('jobs'));
  }


  public function create()
  {
    return view('job.create');
  }
  public function store(JobPostFormRequest $request)
  {

    $this->job->store($request);



    return back();
  }


  public function edit(Listing $listing)
  {
    return view('job.edit', compact('listing'));
  }
  public function update($id, JobEditFormRequest $request)
  {
    $this->job->updatePost($id,$request);
     
    return back()->with('success', 'Your Job post has been successfully uploaded');
  }

  public function destroy($id)
  {
    Listing::find($id)->delete();
    return back()->with('success', 'Your Job post has been successfully deleted');
  }
}
