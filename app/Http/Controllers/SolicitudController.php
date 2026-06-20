<?php

namespace App\Http\Controllers;

use App\Models\Adopcion;
use App\Models\Mascota;
use App\Models\SolicitudAdopcion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SolicitudController extends Controller
{
    private function authorizeShelter(SolicitudAdopcion $solicitud): void
    {
        $shelter = Auth::user()->shelter;

        if (!$shelter || $solicitud->mascota->refugio_id !== $shelter->id) {
            abort(403);
        }
    }

    public function create(Mascota $mascota): View|RedirectResponse
    {
        if ($mascota->status !== 'disponible') {
            return redirect()->route('mascotas.public.show', $mascota)
                ->withErrors(['error' => 'Esta mascota no está disponible para adopción.']);
        }

        $existing = SolicitudAdopcion::where('mascota_id', $mascota->id)
            ->where('user_id', Auth::id())
            ->where('status', 'pendiente')
            ->first();

        if ($existing) {
            return redirect()->route('solicitudes.cuestionario', $existing)
                ->with('success', 'Ya tienes una solicitud pendiente para esta mascota. Completa el cuestionario.');
        }

        $solicitud = SolicitudAdopcion::create([
            'mascota_id' => $mascota->id,
            'user_id' => Auth::id(),
            'status' => 'pendiente',
        ]);

        $mascota->update(['status' => 'pendiente']);

        return redirect()->route('solicitudes.cuestionario', $solicitud)
            ->with('success', 'Solicitud creada. Ahora completa el cuestionario.');
    }

    public function cuestionario(SolicitudAdopcion $solicitud): View
    {
        if ($solicitud->user_id !== Auth::id()) {
            abort(403);
        }

        return view('solicitudes.cuestionario', compact('solicitud'));
    }

    public function guardarCuestionario(Request $request, SolicitudAdopcion $solicitud): RedirectResponse
    {
        if ($solicitud->user_id !== Auth::id()) {
            abort(403);
        }

        if ($solicitud->cuestionario) {
            return redirect()->route('solicitudes.mis-solicitudes')
                ->with('success', 'Ya completaste el cuestionario para esta solicitud.');
        }

        $validated = $request->validate([
            'tipo_vivienda' => ['required', 'in:departamento,casa,otro'],
            'tiene_patio' => ['boolean'],
            'otras_mascotas' => ['boolean'],
            'miembros_familia' => ['required', 'integer', 'min:1'],
            'experiencia_con_mascotas' => ['required', 'string', 'min:20'],
        ]);

        $solicitud->cuestionario()->create([
            'tipo_vivienda' => $validated['tipo_vivienda'],
            'tiene_patio' => $request->boolean('tiene_patio'),
            'otras_mascotas' => $request->boolean('otras_mascotas'),
            'miembros_familia' => $validated['miembros_familia'],
            'experiencia_con_mascotas' => $validated['experiencia_con_mascotas'],
        ]);

        return redirect()->route('solicitudes.mis-solicitudes')
            ->with('success', 'Cuestionario enviado correctamente. El refugio revisará tu solicitud.');
    }

    public function misSolicitudes(): View
    {
        $solicitudes = Auth::user()->solicitudes()
            ->with(['mascota.fotoPrincipal', 'mascota.shelter', 'cuestionario'])
            ->latest()
            ->get();

        return view('solicitudes.mis-solicitudes', compact('solicitudes'));
    }

    public function recibidas(): View
    {
        $shelter = Auth::user()->shelter;

        if (!$shelter) {
            abort(403);
        }

        $solicitudes = SolicitudAdopcion::whereHas('mascota', function ($q) use ($shelter) {
            $q->where('refugio_id', $shelter->id);
        })->with(['mascota.fotoPrincipal', 'adoptante', 'cuestionario'])
            ->latest()
            ->get();

        return view('solicitudes.recibidas', compact('solicitudes'));
    }

    public function detalle(SolicitudAdopcion $solicitud): View
    {
        $this->authorizeShelter($solicitud);

        $solicitud->load(['mascota.fotoPrincipal', 'mascota.shelter', 'adoptante', 'cuestionario', 'adopcion']);

        return view('solicitudes.detalle', compact('solicitud'));
    }

    public function aprobar(SolicitudAdopcion $solicitud): RedirectResponse
    {
        $this->authorizeShelter($solicitud);

        if ($solicitud->status !== 'pendiente') {
            return back()->withErrors(['error' => 'La solicitud ya no está pendiente.']);
        }

        if ($solicitud->mascota->status === 'adoptada') {
            return back()->withErrors(['error' => 'La mascota ya fue adoptada.']);
        }

        if (!$solicitud->cuestionario) {
            return back()->withErrors(['error' => 'La solicitud no tiene cuestionario completo.']);
        }

        $solicitud->update(['status' => 'aprobada']);
        $solicitud->mascota->update(['status' => 'adoptada']);

        Adopcion::create([
            'solicitud_adopcion_id' => $solicitud->id,
            'mascota_id' => $solicitud->mascota_id,
            'adoptante_user_id' => $solicitud->user_id,
            'refugio_id' => $solicitud->mascota->refugio_id,
            'fecha_aprobacion' => now(),
            'status' => 'activa',
        ]);

        SolicitudAdopcion::where('mascota_id', $solicitud->mascota_id)
            ->where('id', '!=', $solicitud->id)
            ->where('status', 'pendiente')
            ->update(['status' => 'rechazada', 'motivo_rechazo' => 'La mascota fue adoptada por otro solicitante.']);

        return back()->with('success', 'Solicitud aprobada. Adopción registrada y otras solicitudes canceladas.');
    }

    public function rechazar(Request $request, SolicitudAdopcion $solicitud): RedirectResponse
    {
        $this->authorizeShelter($solicitud);

        $validated = $request->validate([
            'motivo_rechazo' => ['required', 'string', 'min:10'],
        ]);

        $solicitud->update([
            'status' => 'rechazada',
            'motivo_rechazo' => $validated['motivo_rechazo'],
        ]);

        $hasOtherPending = SolicitudAdopcion::where('mascota_id', $solicitud->mascota_id)
            ->where('status', 'pendiente')
            ->exists();

        if (!$hasOtherPending) {
            $solicitud->mascota->update(['status' => 'disponible']);
        }

        return back()->with('success', 'Solicitud rechazada.');
    }
}
