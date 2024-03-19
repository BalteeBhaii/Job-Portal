<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class doNotAllowUserToMakePayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(auth()->user()->billing_ends > date('Y-m-d')){

            return redirect()->route('dashboard')->with('error', 'You are paid memeber..');
        }
        return $next($request);
    }
}
