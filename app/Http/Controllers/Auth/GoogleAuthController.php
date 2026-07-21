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
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): View|RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        $existingUser = User::where('email', $googleUser->email)->first();

        if ($existingUser) {
            Auth::login($existingUser);

            return redirect(match ($existingUser->role) {
                'admin' => route('dashboard.admin'),
                'refugio' => route('dashboard.refugio'),
                'adoptante' => route('dashboard.adoptante'),
                default => route('login'),
            });
        }

        Session::put('google_user', [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_id' => $googleUser->id,
        ]);

        return view('auth.role-select');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = Session::get('google_user');

        if (!$data) {
            return redirect()->route('login');
        }

        $request->validate([
            'role' => ['required', 'in:refugio,adoptante'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make(str()->random(32)),
            'role' => $request->role,
        ]);

        if ($request->role === 'refugio') {
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

        Session::forget('google_user');

        Auth::login($user);

        return redirect(match ($user->role) {
            'refugio' => route('dashboard.refugio'),
            'adoptante' => route('dashboard.adoptante'),
            default => route('login'),
        });
    }
}
