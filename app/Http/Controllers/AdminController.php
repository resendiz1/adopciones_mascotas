<?php

namespace App\Http\Controllers;

use App\Mail\RefugioAprobado;
use App\Mail\RefugioRechazado;
use App\Models\Adopcion;
use App\Models\Mascota;
use App\Models\Shelter;
use App\Models\SolicitudAdopcion;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function usuarios(): View
    {
        $usuarios = User::with('shelter')->latest()->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function refugios(): View
    {
        $refugios = Shelter::with('user')->withCount('mascotas')->latest()->get();
        return view('admin.refugios.index', compact('refugios'));
    }

    public function mascotas(): View
    {
        $mascotas = Mascota::with(['shelter', 'fotoPrincipal'])->latest()->get();
        return view('admin.mascotas.index', compact('mascotas'));
    }

    public function solicitudes(): View
    {
        $solicitudes = SolicitudAdopcion::with(['mascota.fotoPrincipal', 'adoptante', 'mascota.shelter'])
            ->latest()
            ->get();
        return view('admin.solicitudes.index', compact('solicitudes'));
    }

    public function adopciones(): View
    {
        $adopciones = Adopcion::with(['mascota.fotoPrincipal', 'adoptante', 'shelter'])
            ->latest()
            ->get();
        return view('admin.adopciones.index', compact('adopciones'));
    }

    public function aprobarRefugio(Request $request, Shelter $shelter): RedirectResponse
    {
        $shelter->update(['status' => 'aprobado']);

        Mail::to($shelter->user->email)->send(new RefugioAprobado($shelter));

        return redirect()->route('admin.refugios')
            ->with('success', "Refugio \"{$shelter->name}\" aprobado correctamente.");
    }

    public function rechazarRefugio(Request $request, Shelter $shelter): RedirectResponse
    {
        $shelter->update(['status' => 'rechazado']);

        Mail::to($shelter->user->email)->send(new RefugioRechazado($shelter));

        return redirect()->route('admin.refugios')
            ->with('success', "Refugio \"{$shelter->name}\" rechazado.");
    }
}
