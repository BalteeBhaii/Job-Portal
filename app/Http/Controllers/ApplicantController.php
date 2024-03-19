<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShortlistMail;

class ApplicantController extends Controller
{

    public function index(){
        $listings = Listing::latest()->withCount('users')->where('user_id', auth()->user()->id)->get();
        // $records = DB::table('listing_user')->whereIn('listing_id', $listings->pluck('id'))->get();
       return view('applicants.index',compact('listings'));

    }

    // binding model with route
    public function show(Listing $listing){
        // to only show the listing to that particular user we crated a policy and we register policy in authserviceprovider
        $this->authorize('view', $listing); // calling policy method
        $listing =  Listing::with('users')->where('slug',$listing->slug)->first();
        return view('applicants.show',compact('listing'));
    }

    public function shortlist($listingId, $userId){

        $listing = Listing::find($listingId);
        $user = User::find($userId);
        if($listing){

            $listing->users()->updateExistingPivot($userId ,['shortlisted' => true]);

            Mail::to($user->email)->queue(new ShortlistMail($user->name,$listing->title));
            return back()->with('success' , 'User has been shortlisted....');
        }
        return back();
    }

    public function apply($listingId)
    {
      $user = auth()->user();
      // syncWithoutDetaching didnot create a duplicate record and we use another method to pivot table attached and its create a duplicate record and
      // we want one user only apply one time in single job so we use syncWithoutDetaching
      $user->listings()->syncWithoutDetaching($listingId);

      return back()->with('success','Youe application was successfully submited');
    }

}
