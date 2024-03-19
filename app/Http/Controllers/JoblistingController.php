<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\User;

class JoblistingController extends Controller
{
    public function index(Request $request){

        $salary = $request->query('sort');
        $date = $request->query('date');
        $jobType= $request->query('job_type');

        $listing = Listing::query();

        if($salary === "salary_high_to_low"){
            $listing->orderByRaw('CAST(salary as UNSIGNED) DESC');
        }elseif($salary === "salary_low_to_high"){
            $listing->orderByRaw('CAST(salary as UNSIGNED) ASC ');
        }

        if($date === "latest"){
            $listing->orderBy('created_at', 'desc');
        }elseif($date === "oldest"){
            $listing->orderBy('created_at', 'asc');
        }

        if($jobType === "Fulltime"){
            $listing->where('job_type', 'FullTime');
        }elseif($jobType === "Parttime"){
            $listing->where('job_type', 'PartTime');
        }elseif($jobType  === "Cascual"){
            $listing->where('job_type' , 'Cascual');
        }elseif($jobType  === "Contract"){
            $listing->where('job_type' , 'Contract');
        }

        $jobs  = $listing->with('profile')->get();
        return view('home' , compact('jobs'));
    }

    public function show(Listing $listing){

        return view('show',compact('listing'));
    }

    public function company($id){

        $company =   User::with('jobs')->where('id', $id)->where('user_type' , 'employer')->first();
        return view('company' , compact('company'));
    }

}
