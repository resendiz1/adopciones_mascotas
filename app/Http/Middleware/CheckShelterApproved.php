<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckShelterApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        $shelter = Auth::user()->shelter;

        if (!$shelter || $shelter->status === 'pendiente') {
            return redirect()->route('dashboard.refugio');
        }

        if ($shelter->status === 'rechazado') {
            return redirect()->route('dashboard.refugio');
        }

        return $next($request);
    }
}
