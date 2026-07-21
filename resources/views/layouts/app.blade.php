<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Adopciones Mascotas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar is-light" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ url('/') }}">
                <strong>Adopciones Mascotas</strong>
            </a>

            <button class="navbar-burger" type="button" aria-label="Abrir menú" aria-expanded="false" data-target="main-navbar-menu">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </button>
        </div>

        <div id="main-navbar-menu" class="navbar-menu">
            <div class="navbar-start">
                @php $routeName = request()->route()?->getName(); @endphp
                <a class="navbar-item{{ str_starts_with($routeName, 'mascotas.public.') ? ' is-active' : '' }}" href="{{ route('mascotas.public.index') }}">
                    <span class="icon is-small"><i class="fas fa-paw"></i></span> Mascotas
                </a>
                @auth
                    @php
                        $dashboardRoute = match(Auth::user()->role) {
                            'admin' => 'dashboard.admin',
                            'refugio' => 'dashboard.refugio',
                            'adoptante' => 'dashboard.adoptante',
                            default => 'login',
                        };
                    @endphp
                    <a class="navbar-item{{ $routeName === $dashboardRoute ? ' is-active' : '' }}" href="{{ route($dashboardRoute) }}"><span class="icon is-small"><i class="fas fa-tachometer-alt"></i></span> Dashboard</a>
                    @if (Auth::user()->role === 'adoptante')
                        <a class="navbar-item{{ str_starts_with($routeName, 'favoritos.') ? ' is-active' : '' }}" href="{{ route('favoritos.index') }}"><span class="icon is-small"><i class="fas fa-heart"></i></span> Mis favoritos</a>
                        <a class="navbar-item{{ $routeName === 'solicitudes.mis-solicitudes' ? ' is-active' : '' }}" href="{{ route('solicitudes.mis-solicitudes') }}"><span class="icon is-small"><i class="fas fa-file-alt"></i></span> Mis solicitudes</a>
                        <a class="navbar-item{{ str_starts_with($routeName, 'adoptante.adopciones.') ? ' is-active' : '' }}" href="{{ route('adoptante.adopciones.index') }}"><span class="icon is-small"><i class="fas fa-handshake"></i></span> Mis adopciones</a>
                    @elseif (Auth::user()->role === 'refugio')
                        <a class="navbar-item{{ str_starts_with($routeName, 'refugio.solicitudes.') ? ' is-active' : '' }}" href="{{ route('refugio.solicitudes.recibidas') }}"><span class="icon is-small"><i class="fas fa-file-alt"></i></span> Solicitudes</a>
                        <a class="navbar-item{{ str_starts_with($routeName, 'refugio.adopciones.') ? ' is-active' : '' }}" href="{{ route('refugio.adopciones.index') }}"><span class="icon is-small"><i class="fas fa-handshake"></i></span> Adopciones</a>
                    @elseif (Auth::user()->role === 'admin')
                        <a class="navbar-item{{ $routeName === 'admin.usuarios' ? ' is-active' : '' }}" href="{{ route('admin.usuarios') }}"><span class="icon is-small"><i class="fas fa-users"></i></span> Usuarios</a>
                        <a class="navbar-item{{ $routeName === 'admin.refugios' ? ' is-active' : '' }}" href="{{ route('admin.refugios') }}"><span class="icon is-small"><i class="fas fa-building"></i></span> Refugios</a>
                        <a class="navbar-item{{ str_starts_with($routeName, 'admin.mascotas') ? ' is-active' : '' }}" href="{{ route('admin.mascotas') }}"><span class="icon is-small"><i class="fas fa-paw"></i></span> Mascotas</a>
                        <a class="navbar-item{{ $routeName === 'admin.solicitudes' ? ' is-active' : '' }}" href="{{ route('admin.solicitudes') }}"><span class="icon is-small"><i class="fas fa-file-alt"></i></span> Solicitudes</a>
                        <a class="navbar-item{{ $routeName === 'admin.adopciones' ? ' is-active' : '' }}" href="{{ route('admin.adopciones') }}"><span class="icon is-small"><i class="fas fa-handshake"></i></span> Adopciones</a>
                    @endif
                @endauth
            </div>
            <div class="navbar-end">
                @auth
                    <a class="navbar-item" href="{{ route('profile.edit') }}">
                        <figure class="image is-24x24 mr-2" style="display:inline-flex; vertical-align:middle;">
                            <img class="is-rounded" src="{{ Auth::user()->avatar_url }}" alt="Foto">
                        </figure>
                        {{ Auth::user()->name }}
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="mt-1">
                        @csrf
                        <button class="navbar-item" type="submit" style="border:none; background:none; cursor:pointer;">
                            <span class="icon is-small"><i class="fas fa-sign-out-alt"></i></span> Cerrar sesión
                        </button>
                    </form>
                @else
                    <a class="navbar-item" href="{{ route('login') }}"><span class="icon is-small"><i class="fas fa-sign-in-alt"></i></span> Iniciar sesión</a>
                    <a class="navbar-item" href="{{ route('register') }}"><span class="icon is-small"><i class="fas fa-user-plus"></i></span> Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="section">
        <div class="container">
            @if (session('success'))
                <div class="notification is-success is-light">
                    <span class="icon"><i class="fas fa-check-circle"></i></span> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="notification is-danger is-light">
                    <span class="icon"><i class="fas fa-exclamation-triangle"></i></span>
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
