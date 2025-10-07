<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class Access
{
    public function handle(Request $request, Closure $next, string $status): Response
    {
        if(Auth::user() == null){
            return redirect('/')->with('failed','Access Failed');
        }

        $id    = Auth::user()->id;
        $role  = Auth::user()->role_id;

        if ($status == 'master')
        {
            if ($role == 1) {
                return $next($request);
            } else {
                return back()->with('failed','Access Failed');
            }
        }

        if ($status == 'admin')
        {
            if ($role == 2) {
                return $next($request);
            } else {
                return back()->with('failed','Access Failed');
            }
        }

        if ($status == 'user')
        {
            if ($role == 1 || $role == 3) {
                return $next($request);
            } else {
                return back()->with('failed','Access Failed');
            }
        }



        return $next($request);
    }
}
