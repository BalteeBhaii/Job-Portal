<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    // when we create a constructor then this middleware will apply in all method that exist int  the class
    // this is  the benefit of constructor middleware

    public function __construct(){
        return $this->middleware('auth');
    }

    public function index(){

        return view('dashboard');
    }

    public function verify(){
        return view('user.verify');
    }

    public function resend(Request $request){

        $user = Auth::user();
        if($user->hasVerifiedEmail()){
            return redirect()->route('home')->with('success','Your email was verfied');
        }

        $user->sendEmailVerificationNotification();
        return back()->with('success', 'Verfication link has send successfullly.');
    }
}
