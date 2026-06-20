<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Adopcion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RefugioDashboardController extends Controller
{
    public function __invoke(): View
    {
        $shelter = Auth::user()->shelter;
        $totalMascotas = $shelter?->mascotas()->count() ?? 0;
        $totalAdopciones = $shelter ? Adopcion::where('refugio_id', $shelter->id)->count() : 0;

        return view('dashboard.refugio', compact('shelter', 'totalMascotas', 'totalAdopciones'));
    }
}
