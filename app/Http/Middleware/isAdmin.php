<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //cek dia login @ belum
        //kalau bukan user@guest, kasi abort
        // ||
        //if user sudah login, tapi bukan admin, kasi abort supaya x dapat akses Menu category
        //admin ja boleh akses(ilah)
       
        
        //if user belum login & bukan admin..kasi forbidden page
        if(auth()->guest() || !auth()->user()->is_admin) {
            abort(403); //if user biasa login
        }
            
        
        return $next($request);
    }
}
