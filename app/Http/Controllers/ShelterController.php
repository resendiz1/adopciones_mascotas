<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ShelterController extends Controller
{
    public function edit(): View
    {
        $shelter = Auth::user()->shelter;

        if (!$shelter) {
            $shelter = Auth::user()->shelter()->create([
                'name' => Auth::user()->name,
            ]);
        }

        return view('shelter.edit', compact('shelter'));
    }

    public function update(Request $request): RedirectResponse
    {
        $shelter = Auth::user()->shelter;

        if (!$shelter) {
            $shelter = Auth::user()->shelter()->create([
                'name' => $request->name ?? Auth::user()->name,
            ]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'ciudad' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        $shelter->update($validated);

        return redirect()->route('dashboard.refugio')
            ->with('success', 'Perfil del refugio actualizado correctamente.');
    }
}
