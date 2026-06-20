<?php

namespace App\Http\Controllers;

use App\Models\Adopcion;
use App\Models\SeguimientoVisitaAdopcion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VisitaController extends Controller
{
    public function index(Adopcion $adopcion): View
    {
        $this->authorizeShelter($adopcion);

        $adopcion->load(['mascota', 'adoptante', 'visitas.fotos']);

        return view('adopciones.visitas.index', compact('adopcion'));
    }

    public function store(Request $request, Adopcion $adopcion): RedirectResponse
    {
        $this->authorizeShelter($adopcion);

        $validated = $request->validate([
            'fecha_programada' => ['nullable', 'date'],
            'tipo' => ['required', 'string', 'in:post_adopcion'],
            'notas' => ['nullable', 'string', 'max:2000'],
        ]);

        $adopcion->visitas()->create([
            'user_refugio_id' => Auth::id(),
            'fecha_programada' => $validated['fecha_programada'] ?? null,
            'tipo' => $validated['tipo'],
            'status' => 'pendiente',
            'notas' => $validated['notas'] ?? null,
        ]);

        return back()->with('success', 'Visita de seguimiento creada.');
    }

    public function update(Request $request, Adopcion $adopcion, SeguimientoVisitaAdopcion $visita): RedirectResponse
    {
        $this->authorizeShelter($adopcion);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pendiente,completada,fallida'],
            'fecha_realizada' => ['nullable', 'date'],
            'notas' => ['nullable', 'string', 'max:2000'],
        ]);

        $visita->update($validated);

        return back()->with('success', 'Visita actualizada.');
    }

    public function destroy(Adopcion $adopcion, SeguimientoVisitaAdopcion $visita): RedirectResponse
    {
        $this->authorizeShelter($adopcion);

        foreach ($visita->fotos as $foto) {
            Storage::delete($foto->url);
        }

        $visita->delete();

        return back()->with('success', 'Visita eliminada.');
    }

    public function storeFoto(Request $request, SeguimientoVisitaAdopcion $visita): RedirectResponse
    {
        $this->authorizeShelter($visita->adopcion);

        $validated = $request->validate([
            'foto' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'tipo' => ['required', 'string', 'in:foto,video'],
            'descripcion' => ['nullable', 'string', 'max:500'],
        ]);

        $path = $request->file('foto')->store('visitas', 'public');

        $visita->fotos()->create([
            'url' => $path,
            'tipo' => $validated['tipo'],
            'descripcion' => $validated['descripcion'] ?? null,
        ]);

        return back()->with('success', 'Foto subida correctamente.');
    }

    public function destroyFoto(SeguimientoVisitaAdopcion $visita, \App\Models\FotoVisitaAdopcion $foto): RedirectResponse
    {
        $this->authorizeShelter($visita->adopcion);

        Storage::delete($foto->url);
        $foto->delete();

        return back()->with('success', 'Foto eliminada.');
    }

    private function authorizeShelter(Adopcion $adopcion): void
    {
        $shelter = Auth::user()->shelter;

        if (!$shelter || $adopcion->refugio_id !== $shelter->id) {
            abort(403);
        }
    }
}
