<?php

namespace App\Http\Controllers;

use App\Models\Adopcion;
use App\Models\Mascota;
use App\Models\Shelter;
use App\Models\SolicitudAdopcion;
use App\Models\User;
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
}
