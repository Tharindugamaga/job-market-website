<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicantController extends Controller
{
    public function index()
    {
       
     $listing =Listing::where('user_id',auth()->user()->id)->get();
     $records = DB::table('listing_user')->whereIn('listing_id', $listing->pluck('id'))->get();
       
     dd($records);
    }

    
}
