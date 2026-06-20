<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Adopciones Mascotas')</title>
    @vite('resources/css/app.css')
</head>
<body>
    <nav class="navbar is-light" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ url('/') }}">
                <strong>Adopciones Mascotas</strong>
            </a>
        </div>

        <div class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="{{ route('mascotas.public.index') }}">
                    Mascotas
                </a>
            </div>
            <div class="navbar-end">
                @auth
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="navbar-dropdown">
                            @php
                                $dashboardRoute = match(Auth::user()->role) {
                                    'admin' => 'dashboard.admin',
                                    'refugio' => 'dashboard.refugio',
                                    'adoptante' => 'dashboard.adoptante',
                                    default => 'login',
                                };
                            @endphp
                            <a class="navbar-item" href="{{ route($dashboardRoute) }}">
                                Dashboard
                            </a>
                            @if (Auth::user()->role === 'adoptante')
                                <a class="navbar-item" href="{{ route('favoritos.index') }}">Mis favoritos</a>
                                <a class="navbar-item" href="{{ route('solicitudes.mis-solicitudes') }}">Mis solicitudes</a>
                                <a class="navbar-item" href="{{ route('adoptante.adopciones.index') }}">Mis adopciones</a>
                            @elseif (Auth::user()->role === 'refugio')
                                <a class="navbar-item" href="{{ route('refugio.solicitudes.recibidas') }}">Solicitudes</a>
                                <a class="navbar-item" href="{{ route('refugio.adopciones.index') }}">Adopciones</a>
                            @elseif (Auth::user()->role === 'admin')
                                <a class="navbar-item" href="{{ route('admin.usuarios') }}">Usuarios</a>
                                <a class="navbar-item" href="{{ route('admin.refugios') }}">Refugios</a>
                                <a class="navbar-item" href="{{ route('admin.mascotas') }}">Mascotas</a>
                                <a class="navbar-item" href="{{ route('admin.solicitudes') }}">Solicitudes</a>
                                <a class="navbar-item" href="{{ route('admin.adopciones') }}">Adopciones</a>
                            @endif
                            <hr class="navbar-divider">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="navbar-item" type="submit" style="border:none; background:none; cursor:pointer; width:100%; text-align:left;">
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a class="navbar-item" href="{{ route('login') }}">Iniciar sesión</a>
                    <a class="navbar-item" href="{{ route('register') }}">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="section">
        <div class="container">
            @if (session('success'))
                <div class="notification is-success is-light">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="notification is-danger is-light">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
    @stack('scripts')
</body>
</html>
