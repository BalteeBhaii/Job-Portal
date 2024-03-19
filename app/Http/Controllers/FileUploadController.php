<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FileUploadController extends Controller
{
    public function store(Request $request){

        if($request->hasFile('file')){
            $file = $request->file('file')->store('resume','public');
            User::where('id', auth()->user()->id)->update([
                'resume' => $file
            ]);
            return response()->jscon(['success' => true]);
        }

        return response()->json(['error' => 'error']);
    }
}
