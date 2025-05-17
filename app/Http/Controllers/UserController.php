<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\SeekerRegistrationRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    const JOB_SEEKER = 'seeker';
    public function createSeeker()
    {
        return view('user.seeker-register'); // Make sure the file path matches
    }
    public function storeSeeker(SeekerRegistrationRequest $request)
    {
        // Validate the request
        $request->validated();

        // Check if the user already exists
        if (User::where('email', request('email'))->exists()) {
            return back()->withErrors(['email' => 'Email already exists']);
        } 

            // Create a new user instance
            User::create([
                'name' => request('name'),
                'email' => request('email'),
                'password' => bcrypt(request('password')),
                'user_type' => self::JOB_SEEKER,

            ]);
            return back();
        
    }


    public function login()
    {
        return view('user.login'); // Make sure the file path matches
    }

   

    public function postLogin(Request $request)
    {
       $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
          $credentials = $request->only('email', 'password');
      if(Auth::attempt($credentials)){
        return redirect()->intended('/dashboard');
    
    }
    return 'wrong email or password';
}

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('login');
    }
};
