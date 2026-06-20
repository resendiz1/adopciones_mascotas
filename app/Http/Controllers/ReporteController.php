<?php

namespace App\Http\Controllers;

use App\Models\Adopcion;
use App\Models\Mascota;
use App\Models\ReporteAdopcion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ReporteController extends Controller
{
    public function misAdopciones(): View
    {
        $adopciones = Adopcion::where('adoptante_user_id', Auth::id())
            ->with(['mascota.fotoPrincipal', 'shelter', 'reportes'])
            ->latest()
            ->get();

        return view('adoptante.adopciones.index', compact('adopciones'));
    }

    public function create(Adopcion $adopcion): View
    {
        $this->authorizeAdoptante($adopcion);

        $adopcion->load('mascota');

        return view('adoptante.reportes.create', compact('adopcion'));
    }

    public function store(Request $request, Adopcion $adopcion): RedirectResponse
    {
        $this->authorizeAdoptante($adopcion);

        $validated = $request->validate([
            'descripcion_reporte' => ['required', 'string', 'min:20', 'max:5000'],
        ]);

        $reporte = $adopcion->reportes()->create([
            'adoptante_id' => Auth::id(),
            'mascota_id' => $adopcion->mascota_id,
            'status' => 'pendiente',
            'descripcion_reporte' => $validated['descripcion_reporte'],
        ]);

        return redirect()->route('adoptante.reportes.fotos', $reporte)
            ->with('success', 'Reporte enviado. Puedes agregar fotos.');
    }

    public function fotosForm(ReporteAdopcion $reporte): View
    {
        $this->authorizeAdoptanteReporte($reporte);

        $reporte->load(['adopcion.mascota', 'fotos']);

        return view('adoptante.reportes.fotos', compact('reporte'));
    }

    public function storeFoto(Request $request, ReporteAdopcion $reporte): RedirectResponse
    {
        $this->authorizeAdoptanteReporte($reporte);

        $validated = $request->validate([
            'foto' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'tipo' => ['required', 'string', 'in:foto,video'],
        ]);

        $path = $request->file('foto')->store('reportes', 'public');

        $reporte->fotos()->create([
            'url' => $path,
            'tipo' => $validated['tipo'],
        ]);

        return back()->with('success', 'Foto subida correctamente.');
    }

    public function destroyFoto(ReporteAdopcion $reporte, \App\Models\FotoReporteAdopcion $foto): RedirectResponse
    {
        $this->authorizeAdoptanteReporte($reporte);

        Storage::delete($foto->url);
        $foto->delete();

        return back()->with('success', 'Foto eliminada.');
    }

    public function index(Adopcion $adopcion): View
    {
        $this->authorizeShelter($adopcion);

        $adopcion->load(['mascota', 'adoptante', 'reportes.fotos']);

        return view('adopciones.reportes.index', compact('adopcion'));
    }

    public function update(Request $request, Adopcion $adopcion, ReporteAdopcion $reporte): RedirectResponse
    {
        $this->authorizeShelter($adopcion);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pendiente,revisado,requiere_atencion'],
        ]);

        $reporte->update(['status' => $validated['status']]);

        return back()->with('success', 'Reporte actualizado.');
    }

    private function authorizeShelter(Adopcion $adopcion): void
    {
        $shelter = Auth::user()->shelter;

        if (!$shelter || $adopcion->refugio_id !== $shelter->id) {
            abort(403);
        }
    }

    private function authorizeAdoptante(Adopcion $adopcion): void
    {
        if ($adopcion->adoptante_user_id !== Auth::id()) {
            abort(403);
        }
    }

    private function authorizeAdoptanteReporte(ReporteAdopcion $reporte): void
    {
        if ($reporte->adoptante_id !== Auth::id()) {
            abort(403);
        }
    }
}
