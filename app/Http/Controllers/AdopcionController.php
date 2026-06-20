<?php

namespace App\Http\Controllers;

use App\Models\Adopcion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdopcionController extends Controller
{
    public function index(): View
    {
        $shelter = Auth::user()->shelter;

        if (!$shelter) {
            abort(403);
        }

        $adopciones = Adopcion::where('refugio_id', $shelter->id)
            ->with(['mascota.fotoPrincipal', 'adoptante', 'solicitud'])
            ->latest()
            ->get();

        return view('adopciones.index', compact('adopciones'));
    }

    public function finalizar(Adopcion $adopcion): RedirectResponse
    {
        $this->authorizeShelter($adopcion);

        if ($adopcion->status !== 'activa') {
            return back()->withErrors(['error' => 'Solo se pueden finalizar adopciones activas.']);
        }

        $adopcion->update(['status' => 'finalizada']);

        return back()->with('success', 'Adopción finalizada correctamente.');
    }

    public function cancelar(Request $request, Adopcion $adopcion): RedirectResponse
    {
        $this->authorizeShelter($adopcion);

        if ($adopcion->status !== 'activa') {
            return back()->withErrors(['error' => 'Solo se pueden cancelar adopciones activas.']);
        }

        $validated = $request->validate([
            'motivo_cancelacion' => ['required', 'string', 'min:10'],
        ]);

        $adopcion->update([
            'status' => 'cancelada',
            'notas' => $validated['motivo_cancelacion'],
        ]);

        return back()->with('success', 'Adopción cancelada.');
    }

    private function authorizeShelter(Adopcion $adopcion): void
    {
        $shelter = Auth::user()->shelter;

        if (!$shelter || $adopcion->refugio_id !== $shelter->id) {
            abort(403);
        }
    }
}
