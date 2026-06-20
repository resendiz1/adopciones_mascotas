<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Mascota;
use App\Models\Shelter;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdoptanteDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = Mascota::where('status', 'disponible')
            ->with(['shelter', 'fotoPrincipal']);

        if ($request->filled('especie')) {
            $query->where('especie', $request->especie);
        }
        if ($request->filled('sexo')) {
            $query->where('sexo', $request->sexo);
        }
        if ($request->filled('tamano')) {
            $query->where('tamano', $request->tamano);
        }
        if ($request->filled('ciudad')) {
            $query->whereHas('shelter', fn($q) => $q->where('ciudad', $request->ciudad));
        }
        if ($request->filled('estado')) {
            $query->whereHas('shelter', fn($q) => $q->where('estado', $request->estado));
        }

        $mascotas = $query->latest()->get();

        $ciudades = Shelter::whereNotNull('ciudad')->distinct()->pluck('ciudad')->sort();
        $estados = Shelter::whereNotNull('estado')->distinct()->pluck('estado')->sort();

        return view('dashboard.adoptante', compact('mascotas', 'ciudades', 'estados'));
    }
}
