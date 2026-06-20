@extends('layouts.app')

@section('title', 'Bienvenido')

@section('content')
    <div class="hero is-medium">
        <div class="hero-body has-text-centered">
            <h1 class="title is-1">Adopciones Mascotas</h1>
            <p class="subtitle is-4">Encuentra a tu nuevo mejor amigo</p>

            <div class="buttons is-centered mt-5">
                @guest
                    <a href="{{ route('register') }}" class="button is-primary is-large">Registrarse</a>
                    <a href="{{ route('login') }}" class="button is-info is-large">Iniciar sesión</a>
                @else
                    @php
                        $dashboardRoute = match(Auth::user()->role) {
                            'admin' => 'dashboard.admin',
                            'refugio' => 'dashboard.refugio',
                            'adoptante' => 'dashboard.adoptante',
                            default => 'login',
                        };
                    @endphp
                    <a href="{{ route($dashboardRoute) }}" class="button is-primary is-large">
                        Ir al dashboard
                    </a>
                @endguest
            </div>
        </div>
    </div>
@endsection
