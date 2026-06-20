<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavoritoController extends Controller
{
    public function index(): View
    {
        $favoritos = Auth::user()->favoritos()
            ->with('mascota.fotoPrincipal', 'mascota.shelter')
            ->latest()
            ->get();

        return view('favoritos.index', compact('favoritos'));
    }

    public function toggle(Mascota $mascota): RedirectResponse
    {
        $user = Auth::user();

        $favorito = $user->favoritos()->where('mascota_id', $mascota->id)->first();

        if ($favorito) {
            $favorito->delete();
            return back()->with('success', 'Mascota eliminada de favoritos.');
        }

        $user->favoritos()->create(['mascota_id' => $mascota->id]);

        return back()->with('success', 'Mascota agregada a favoritos.');
    }
}
