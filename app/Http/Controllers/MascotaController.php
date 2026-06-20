<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\FotoMascota;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MascotaController extends Controller
{
    public function index(): View
    {
        $mascotas = Auth::user()->shelter->mascotas()->with('fotoPrincipal')->latest()->get();
        return view('mascotas.index', compact('mascotas'));
    }

    public function create(): View
    {
        return view('mascotas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'especie' => ['required', 'string', 'max:100'],
            'raza' => ['nullable', 'string', 'max:255'],
            'edad_meses' => ['nullable', 'integer', 'min:0'],
            'sexo' => ['required', 'in:macho,hembra'],
            'tamano' => ['required', 'in:pequeno,mediano,grande'],
            'peso' => ['nullable', 'numeric', 'min:0'],
            'descripcion' => ['required', 'string'],
            'esterilizado' => ['boolean'],
            'desparasitado' => ['boolean'],
            'status' => ['required', 'in:disponible,pendiente,adoptada'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['refugio_id'] = Auth::user()->shelter->id;
        $validated['esterilizado'] = $request->boolean('esterilizado');
        $validated['desparasitado'] = $request->boolean('desparasitado');

        $mascota = Mascota::create($validated);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('mascotas', 'public');
            $mascota->fotoPrincipal()->create([
                'imagen_path' => $path,
                'is_primary' => true,
            ]);
        }

        return redirect()->route('mascotas.index')
            ->with('success', 'Mascota registrada correctamente.');
    }

    public function edit(Mascota $mascota): View
    {
        $this->authorize('same-shelter', $mascota);
        return view('mascotas.edit', compact('mascota'));
    }

    public function update(Request $request, Mascota $mascota): RedirectResponse
    {
        $this->authorize('same-shelter', $mascota);

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'especie' => ['required', 'string', 'max:100'],
            'raza' => ['nullable', 'string', 'max:255'],
            'edad_meses' => ['nullable', 'integer', 'min:0'],
            'sexo' => ['required', 'in:macho,hembra'],
            'tamano' => ['required', 'in:pequeno,mediano,grande'],
            'peso' => ['nullable', 'numeric', 'min:0'],
            'descripcion' => ['required', 'string'],
            'esterilizado' => ['boolean'],
            'desparasitado' => ['boolean'],
            'status' => ['required', 'in:disponible,pendiente,adoptada'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['esterilizado'] = $request->boolean('esterilizado');
        $validated['desparasitado'] = $request->boolean('desparasitado');

        $mascota->update($validated);

        if ($request->hasFile('foto')) {
            $oldFoto = $mascota->fotoPrincipal;
            if ($oldFoto) {
                Storage::disk('public')->delete($oldFoto->imagen_path);
                $oldFoto->delete();
            }

            $path = $request->file('foto')->store('mascotas', 'public');
            $mascota->fotoPrincipal()->create([
                'imagen_path' => $path,
                'is_primary' => true,
            ]);
        }

        return redirect()->route('mascotas.index')
            ->with('success', 'Mascota actualizada correctamente.');
    }

    public function destroy(Mascota $mascota): RedirectResponse
    {
        $this->authorize('same-shelter', $mascota);

        if ($mascota->fotoPrincipal) {
            Storage::disk('public')->delete($mascota->fotoPrincipal->imagen_path);
        }

        $mascota->delete();

        return redirect()->route('mascotas.index')
            ->with('success', 'Mascota eliminada correctamente.');
    }
}
