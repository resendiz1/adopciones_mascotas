<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MascotaPublicController extends Controller
{
    public function index(Request $request): View
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

        $ciudades = \App\Models\Shelter::whereNotNull('ciudad')->distinct()->pluck('ciudad')->sort();
        $estados = \App\Models\Shelter::whereNotNull('estado')->distinct()->pluck('estado')->sort();

        return view('mascotas.public.index', compact('mascotas', 'ciudades', 'estados'));
    }

    public function show(Mascota $mascota): View
    {
        $mascota->load(['shelter', 'fotoPrincipal', 'vacunas.vacuna', 'eventosMedicos']);
        return view('mascotas.public.show', compact('mascota'));
    }
}
