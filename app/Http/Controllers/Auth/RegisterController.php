<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NuevaSolicitudRefugio;
use App\Mail\RefugioRegistrado;
use App\Models\Shelter;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:refugio,adoptante'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($user->role === 'refugio') {
            $shelter = Shelter::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'status' => 'pendiente',
            ]);

            Mail::to($user->email)->send(new RefugioRegistrado($user));

            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                Mail::to($admin->email)->send(new NuevaSolicitudRefugio($shelter));
            }
        }

        Auth::login($user);

        return redirect($this->redirectTo($user));
    }

    private function redirectTo(User $user): string
    {
        return match ($user->role) {
            'admin' => route('dashboard.admin'),
            'refugio' => route('dashboard.refugio'),
            'adoptante' => route('dashboard.adoptante'),
            default => route('login'),
        };
    }
}
