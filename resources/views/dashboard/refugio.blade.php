@extends('layouts.app')

@section('title', 'Dashboard Refugio')

@section('content')
    <h1 class="title">Dashboard Refugio</h1>

    @if ($shelter && $shelter->status === 'pendiente')
        <div class="notification is-warning">
            <span class="icon"><i class="fas fa-clock"></i></span>
            <strong>Tu refugio está pendiente de aprobación.</strong> Un administrador revisará tu perfil pronto. Mientras tanto, puedes editar tu perfil pero no podrás gestionar mascotas, solicitudes ni adopciones.
        </div>
    @elseif ($shelter && $shelter->status === 'rechazado')
        <div class="notification is-danger">
            <span class="icon"><i class="fas fa-times-circle"></i></span>
            <strong>Tu refugio ha sido rechazado.</strong> Comunícate con el administrador para más información.
        </div>
    @endif

    <div class="columns mt-4">
        <div class="column is-one-third">
            <div class="box profile-card">
                <div class="level is-mobile mb-5">
                    <div class="level-left">
                        <div class="level-item">
                            <div class="profile-avatar">
                                <figure class="image is-48x48" style="margin:0;">
                                    <img class="is-rounded" src="{{ Auth::user()->avatar_url }}" alt="Foto">
                                </figure>
                            </div>
                        </div>

                        <div class="level-item">
                            <div>
                                <p class="is-size-7 has-text-grey is-uppercase has-text-weight-semibold">
                                    Perfil del refugio
                                </p>

                                <h2 class="title is-4 mb-1">
                                    {{ $shelter->name ?? 'Sin nombre' }}
                                </h2>

                                @if ($shelter)
                                    <div class="is-flex is-align-items-center is-flex-wrap-wrap" style="gap:0.5rem;">
                                        <span class="tag is-{{ $shelter->status === 'aprobado' ? 'success' : ($shelter->status === 'pendiente' ? 'warning' : 'danger') }} is-light">
                                            <span class="icon is-small">
                                                <i class="fas fa-{{ $shelter->status === 'aprobado' ? 'check-circle' : ($shelter->status === 'pendiente' ? 'clock' : 'times-circle') }}"></i>
                                            </span>
                                            <span>{{ ucfirst($shelter->status) }}</span>
                                        </span>
                                        <a href="{{ route('refugio.shelter.edit') }}" class="has-text-primary has-text-weight-semibold is-size-7">
                                            <span class="icon is-small"><i class="fas fa-pen"></i></span>
                                            <span>Editar perfil</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if ($shelter)
                    <div class="columns is-multiline">
                        <div class="column is-12">
                            <div class="profile-description">
                                <p class="profile-label">
                                    <span class="icon">
                                        <i class="fas fa-align-left"></i>
                                    </span>
                                    Descripción
                                </p>

                                <p class="profile-value">
                                    {{ $shelter->description ?? 'Sin descripción' }}
                                </p>
                            </div>
                        </div>

                        <div class="column is-12">
                            <div class="profile-item">
                                <span class="icon has-text-primary">
                                    <i class="fas fa-location-dot"></i>
                                </span>

                                <div>
                                    <p class="profile-label">Dirección</p>
                                    <p class="profile-value">{{ $shelter->address ?? 'Sin dirección' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="column is-12">
                            <div class="profile-item">
                                <span class="icon has-text-primary">
                                    <i class="fas fa-city"></i>
                                </span>

                                <div>
                                    <p class="profile-label">Ciudad</p>
                                    <p class="profile-value">{{ $shelter->ciudad ?? 'Sin especificar' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="column is-12">
                            <div class="profile-item">
                                <span class="icon has-text-primary">
                                    <i class="fas fa-map"></i>
                                </span>

                                <div>
                                    <p class="profile-label">Estado</p>
                                    <p class="profile-value">{{ $shelter->estado ?? 'Sin especificar' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="column is-12">
                            <div class="profile-item">
                                <span class="icon has-text-primary">
                                    <i class="fas fa-phone"></i>
                                </span>

                                <div>
                                    <p class="profile-label">Teléfono</p>
                                    <p class="profile-value">{{ $shelter->phone ?? 'Sin teléfono' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p>Aún no has configurado tu refugio.</p>
                @endif

            </div>
        </div>

        <div class="column">
            <div class="box">
                <div class="level">
                    <div class="level-left">
                        <h2 class="subtitle">Mis Mascotas</h2>
                    </div>
                    <div class="level-right">
                        <a href="{{ route('refugio.mascotas.index') }}" class="button is-primary is-small">
                            <span class="icon is-small"><i class="fas fa-paw"></i></span>
                            <span>Administrar</span>
                        </a>
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
                        <a href="{{ route('refugio.solicitudes.recibidas') }}" class="button is-info is-small">
                            <span class="icon is-small"><i class="fas fa-file-lines"></i></span>
                            <span>Ver solicitudes</span>
                        </a>
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
                        <a href="{{ route('refugio.adopciones.index') }}" class="button is-success is-small">
                            <span class="icon is-small"><i class="fas fa-handshake"></i></span>
                            <span>Ver adopciones</span>
                        </a>
                    </div>
                </div>
                <p><strong>Total:</strong> {{ $totalAdopciones }} adopción(es) registradas.</p>
            </div>
        </div>
    </div>
@endsection
