<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\SeekerRegistrationRequest;
use App\Http\Requests\EmployerRegistrationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    const  JOBSEEKER = 'seeker';
    const  JOBPOSTER = 'employer';
    public function createSeeker(){

        return view('user.seeker-register');
    }

    public function storeSeeker(SeekerRegistrationRequest $request){
        // We create a request class php artisan make:request SeekerRegistrationRequest in this class we set validation
       $user =  User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'user_type' => self::JOBSEEKER
        ]);
        Auth::login($user); // to login user proagmatically
        $user->sendEmailVerificationNotification();

        return response()->json('success');
        // return redirect()->route('verification.notice')->with('successMessage', 'Your account was created.');

    }

    public function login(){
        return view('user.login');
    }

    public function postLogin(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentails = $request->only('email', 'password');

        if(Auth::attempt($credentails)){
            if(auth()->user()->user_type == 'employer'){

                return redirect()->to('dashboard');
            }else{
                return redirect()->to('/');
            }
        }

        return "Wrong Email and Password";
    }

    public function logout(){

        auth()->logout();
        return redirect()->route('login');
    }

    public function createEmployer(){
        return view('user.employer-register');
    }

    public function storeEmployer(EmployerRegistrationRequest $request){

       $employer =  User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'user_type' => self::JOBPOSTER,
            'user_trial' => now()->addWeek() // when employer use this website the trial period is 7 days after 7 days it has to be pay to use that website

        ]);
        Auth::login($employer);
        $employer->sendEmailVerificationNotification();
        return response()->json('success');
        // return redirect()->route('verification.notice')->with('successMessage', 'Your account was created.');
    }

    public function profile(){
        return view('profile.index');
    }

    public function update(Request $request){
        if($request->hasFile('profile_pic')){
            $imagePath = $request->file('profile_pic')->store('profile','public');
            User::find(auth()->user()->id)->update(['profile_pic'=>$imagePath]);
        }

        User::find(auth()->user()->id)->update($request->except('profile_pic'));
        return back()->with('success', 'Your profile has been updated...');
    }

    public function seekerProfile(){
        return view('seeker.profile');
    }

    public function changePassword(Request $request){

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = auth()->user();
        if(!Hash::check($request->current_password , $user->password)){
            return back()->with('error', 'Current Password is incorrect..');
        }
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password has been changed successfully.');
    }

    public function uploadResume(Request $request){

        $request->validate([
            'resume' => 'required|mimes:pdf,doc,docx',
        ]);

        if($request->hasFile('resume')){
            $resume  = $request->file('resume')->store('resume','public');
            User::find(auth()->user()->id)->update(['resume' => $resume]);
        }
        return back()->with('success', 'Resume has been uploaded successfully.');

    }

    public function jobApplied(){

         $users =  User::with('listings')->where('id' , auth()->user()->id)->get();
        return view('seeker.job-applied' , compact('users'));

    }
}
