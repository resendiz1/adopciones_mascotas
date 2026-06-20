@extends('layouts.app')

@section('title', 'Dashboard Refugio')

@section('content')
    <h1 class="title">Dashboard Refugio</h1>

    <div class="columns mt-4">
        <div class="column is-one-third">
            <div class="box">
                <h2 class="subtitle">Mi Perfil</h2>

                @if ($shelter)
                    <p><strong>Nombre:</strong> {{ $shelter->name }}</p>
                    <p><strong>Descripción:</strong> {{ $shelter->description ?? 'Sin descripción' }}</p>
                    <p><strong>Dirección:</strong> {{ $shelter->address ?? 'Sin dirección' }}</p>
                    <p><strong>Ciudad:</strong> {{ $shelter->ciudad ?? 'Sin especificar' }}</p>
                    <p><strong>Estado:</strong> {{ $shelter->estado ?? 'Sin especificar' }}</p>
                    <p><strong>Teléfono:</strong> {{ $shelter->phone ?? 'Sin teléfono' }}</p>
                @else
                    <p>Aún no has configurado tu refugio.</p>
                @endif
                <div class="mt-3">
                    <a href="{{ route('refugio.shelter.edit') }}" class="button is-primary is-small">Editar perfil</a>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="box">
                <div class="level">
                    <div class="level-left">
                        <h2 class="subtitle">Mis Mascotas</h2>
                    </div>
                    <div class="level-right">
                        <a href="{{ route('refugio.mascotas.index') }}" class="button is-primary is-small">Administrar</a>
                    </div>
                </div>
                <p><strong>Total:</strong> {{ $totalMascotas }} mascota(s) registradas.</p>
            </div>

            <div class="box">
                <div class="level">
                    <div class="level-left">
                        <h2 class="subtitle">Solicitudes</h2>
                    </div>
                    <div class="level-right">
                        <a href="{{ route('refugio.solicitudes.recibidas') }}" class="button is-info is-small">Ver solicitudes</a>
                    </div>
                </div>
                <p>Revisa las solicitudes de adopción recibidas.</p>
            </div>

            <div class="box">
                <div class="level">
                    <div class="level-left">
                        <h2 class="subtitle">Adopciones</h2>
                    </div>
                    <div class="level-right">
                        <a href="{{ route('refugio.adopciones.index') }}" class="button is-success is-small">Ver adopciones</a>
                    </div>
                </div>
                <p><strong>Total:</strong> {{ $totalAdopciones }} adopción(es) registradas.</p>
            </div>
        </div>
    </div>
@endsection
