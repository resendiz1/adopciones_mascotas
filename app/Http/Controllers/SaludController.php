<?php

namespace App\Http\Controllers;

use App\Models\EventoMedico;
use App\Models\Mascota;
use App\Models\MascotaVacuna;
use App\Models\Vacuna;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SaludController extends Controller
{
    public function index(Mascota $mascota): View
    {
        $this->authorizeShelter($mascota);

        $mascota->load(['vacunas.vacuna', 'eventosMedicos']);

        $vacunasDisponibles = Vacuna::orderBy('nombre')->get();

        return view('salud.index', compact('mascota', 'vacunasDisponibles'));
    }

    public function storeVacuna(Request $request, Mascota $mascota): RedirectResponse
    {
        $this->authorizeShelter($mascota);

        $validated = $request->validate([
            'vacuna_id' => ['required', 'exists:vacunas,id'],
            'fecha_aplicacion' => ['nullable', 'date'],
            'proxima_dosis' => ['nullable', 'date', 'after_or_equal:fecha_aplicacion'],
            'notas' => ['nullable', 'string', 'max:1000'],
        ]);

        $mascota->vacunas()->create($validated);

        return back()->with('success', 'Vacuna registrada correctamente.');
    }

    public function updateVacuna(Request $request, Mascota $mascota, MascotaVacuna $vacuna): RedirectResponse
    {
        $this->authorizeShelter($mascota);

        $validated = $request->validate([
            'vacuna_id' => ['required', 'exists:vacunas,id'],
            'fecha_aplicacion' => ['nullable', 'date'],
            'proxima_dosis' => ['nullable', 'date', 'after_or_equal:fecha_aplicacion'],
            'notas' => ['nullable', 'string', 'max:1000'],
        ]);

        $vacuna->update($validated);

        return back()->with('success', 'Vacuna actualizada correctamente.');
    }

    public function destroyVacuna(Mascota $mascota, MascotaVacuna $vacuna): RedirectResponse
    {
        $this->authorizeShelter($mascota);

        $vacuna->delete();

        return back()->with('success', 'Registro de vacuna eliminado.');
    }

    public function storeEvento(Request $request, Mascota $mascota): RedirectResponse
    {
        $this->authorizeShelter($mascota);

        $validated = $request->validate([
            'fecha' => ['nullable', 'date'],
            'tipo' => ['required', 'string', 'max:50'],
            'titulo_evento' => ['required', 'string', 'max:255'],
            'notas' => ['nullable', 'string', 'max:2000'],
        ]);

        $mascota->eventosMedicos()->create($validated);

        return back()->with('success', 'Evento médico registrado.');
    }

    public function updateEvento(Request $request, Mascota $mascota, EventoMedico $evento): RedirectResponse
    {
        $this->authorizeShelter($mascota);

        $validated = $request->validate([
            'fecha' => ['nullable', 'date'],
            'tipo' => ['required', 'string', 'max:50'],
            'titulo_evento' => ['required', 'string', 'max:255'],
            'notas' => ['nullable', 'string', 'max:2000'],
        ]);

        $evento->update($validated);

        return back()->with('success', 'Evento médico actualizado.');
    }

    public function destroyEvento(Mascota $mascota, EventoMedico $evento): RedirectResponse
    {
        $this->authorizeShelter($mascota);

        $evento->delete();

        return back()->with('success', 'Evento médico eliminado.');
    }

    private function authorizeShelter(Mascota $mascota): void
    {
        $shelter = Auth::user()->shelter;

        if (!$shelter || $mascota->refugio_id !== $shelter->id) {
            abort(403);
        }
    }
}
