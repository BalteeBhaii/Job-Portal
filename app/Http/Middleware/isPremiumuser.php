<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isPremiumuser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // we check user are in trial or in billing when user are in trial they should also post a job and when trial end and we check
        // billing is end or not if it is not they will also post a job and if both are false it means it is not a premium user.
        if($request->user()->user_trial > date('Y-m-d') || $request->user()->billing_ends > date('Y-m-d')){

            return $next($request);
        }

        return redirect()->route('subscribe')->with('message','Please subscribe to post a job.');

    }
}
