@extends('layouts.app')

@section('title', 'Mis Solicitudes')

@section('content')
    <h1 class="title"><span class="icon"><i class="fas fa-file-alt"></i></span> Mis Solicitudes</h1>

    @if ($solicitudes->isEmpty())
        <div class="box has-text-centered">
            <p class="subtitle">No has enviado solicitudes de adopción.</p>
            <a href="{{ route('mascotas.public.index') }}" class="button is-primary"><span class="icon is-small"><i class="fas fa-paw"></i></span> Ver mascotas</a>
        </div>
    @else
        <div class="columns is-multiline">
            @foreach ($solicitudes as $solicitud)
                <div class="column is-one-third">
                    <div class="card">
                        <div class="card-image">
                            <figure class="image is-4by3">
                                @if ($solicitud->mascota->fotoPrincipal)
                                    <img src="{{ Storage::url($solicitud->mascota->fotoPrincipal->imagen_path) }}" alt="{{ $solicitud->mascota->nombre }}">
                                @else
                                    <img src="/img/default_mascota.png" alt="Sin foto">
                                @endif
                            </figure>
                        </div>
                        <div class="card-content">
                            <p class="title is-5">{{ $solicitud->mascota->nombre }}</p>
                            <div class="content">
                                <span class="tag @switch($solicitud->status)
                                    @case('pendiente') is-warning @break
                                    @case('aprobada') is-success @break
                                    @case('rechazada') is-danger @break
                                @endswitch">
                                    {{ ucfirst($solicitud->status) }}
                                </span>

                                @if (!$solicitud->cuestionario)
                                    <span class="tag is-light"><span class="icon is-small"><i class="fas fa-hourglass"></i></span> Cuestionario pendiente</span>
                                @endif

                                @if ($solicitud->motivo_rechazo)
                                    <div class="mt-2">
                                        <p class="has-text-danger is-size-7"><span class="icon is-small"><i class="fas fa-exclamation-circle"></i></span> <strong>Motivo:</strong> {{ $solicitud->motivo_rechazo }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <footer class="card-footer">
                            <a href="{{ route('mascotas.public.show', $solicitud->mascota) }}" class="card-footer-item"><span class="icon is-small"><i class="fas fa-eye"></i></span> Ver mascota</a>
                            @if (!$solicitud->cuestionario && $solicitud->status === 'pendiente')
                                <a href="{{ route('solicitudes.cuestionario', $solicitud) }}" class="card-footer-item has-text-primary"><span class="icon is-small"><i class="fas fa-edit"></i></span> Completar cuestionario</a>
                            @endif
                        </footer>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
