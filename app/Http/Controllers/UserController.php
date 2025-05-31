<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegistrationFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    const JOB_SEEKER = 'seeker';
    const JOB_POSTER = 'employer';

    public function createSeeker()
    {
        return view('user.seeker-register'); // Make sure the file path matches
    }

    public function createEmployer()
    {
        return view('user.employer-register'); // Make sure the file path matches
    }







    public function storeSeeker(RegistrationFormRequest $request)
    {
        // Validate the request
        $request->validated();

        // Check if the user already exists
        if (User::where('email', request('email'))->exists()) {
            return back()->withErrors(['email' => 'Email already exists']);
        }

        // Create a new user instance
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'user_type' => self::JOB_SEEKER,

        ]);
        Auth::login($user);


        $user->sendEmailVerificationNotification(); // Send verification email 


        return response()->json('success');


        //return redirect()->route('verification.notice')->with('successMessage', 'Registration successful! You can now log in.'); // Redirect to login with success message

    }
    public function storeEmployer(RegistrationFormRequest $request)
    {
        // Validate the request
        $request->validated();

        // Check if the user already exists
        if (User::where('email', request('email'))->exists()) {
            return back()->withErrors(['email' => 'Email already exists']);
        }

        // Create a new user instance
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'user_type' => self::JOB_POSTER,
            'user_trial' => now()->addWeek()

        ]);

        Auth::login($user); // Log in the user

        $user->sendEmailVerificationNotification(); // Send verification email

        return response()->json('success');

        // return redirect()->route('verification.notice')->with('successMessage', 'Registration successful! You can now log in.'); // Redirect to login with success message

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
        if (Auth::attempt($credentials)) {
            if (auth()->user()->user_type == 'employer') {
                return redirect()->to('dashboard');
            } else {
                return redirect()->to('/');
            }
        }
        return 'wrong email or password';
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function profile()
    {
        return view('profile.index');
    }

    public function seekerProfile()
    {
        return view('seeker.profile');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::find(auth()->id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password changed successfully');
    }

public function uploadResume(Request $request)
{
    $this->validate($request, [
        'resume' => 'required|mimes:pdf,doc,docx|max:8048',
    ]);

    if ($request->hasFile('resume')) {
        $resume = $request->file('resume')->store('resume', 'public');

        User::find(auth()->user()->id)->update(['resume' => $resume]);

        return back()->with('success', 'Resume uploaded successfully');
    }

    return back()->with('error', 'Please upload a valid resume');
}





    public function update(Request $request)
    {
        if ($request->hasFile('profile_pic')) {

            $imagepath = $request->file('profile_pic')->store('profile_pic', 'public');


            User::find(auth()->user()->id)->update(['profile_pic' => $imagepath]);
        }
        User::find(auth()->user()->id)->update($request->except('profile_pic'));

        return back()->with('success', 'Profile updated successfully');
    }
};
