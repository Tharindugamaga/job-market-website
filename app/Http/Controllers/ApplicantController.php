<?php

namespace App\Http\Controllers;

use App\Mail\ShortlistMail;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;



class ApplicantController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }

        $listings = Listing::latest()->withCount('users')->where('user_id', auth()->user()->id)->get();
        return view('applicants.index', compact('listings'));
    }
    public function show(Listing $listing)
    {
        $this->authorize('view', $listing);
       
       
        $listings =  Listing::with('users')->where('slug', $listing->slug)->first();
        return view('applicants.show', compact('listing'));
        //return $listing;

    }
    public function shortlist($listingId, $userId)
    {
        $listing = Listing::findOrFail($listingId);
        $user = User::find($userId);
        // Remove shortlist status from all users for this listing
        $listing->users()->updateExistingPivot(
            $listing->users->pluck('id'),
            ['shortlisted' => false]
        );

        // Shortlist the selected user
        $listing->users()->updateExistingPivot($userId, ['shortlisted' => true]);

        Mail::to($user->email)->queue(new ShortlistMail($user->name, $listing->title));

        return back()->with('success', 'Applicant successfully shortlisted.');
    }
     public function apply ($listingId)
     {
         $user= auth()->user();
         $user->listings()->syncWithoutDetaching([$listingId]);
        return back()->with('success', 'You have successfully applied for this job.');
     }
}
