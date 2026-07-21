@extends('layouts.app')

@section('title', 'Mis Adopciones')

@section('content')
    <h1 class="title"><span class="icon"><i class="fas fa-handshake"></i></span> Mis adopciones</h1>

    @if ($adopciones->isEmpty())
        <div class="box has-text-centered">
            <p class="subtitle">No tienes adopciones registradas.</p>
            <a href="{{ route('mascotas.public.index') }}" class="button is-primary"><span class="icon is-small"><i class="fas fa-paw"></i></span> Ver mascotas disponibles</a>
        </div>
    @else
        <div class="columns is-multiline">
            @foreach ($adopciones as $adopcion)
                <div class="column is-half">
                    <div class="box">
                        <div class="level">
                            <div class="level-left">
                                <figure class="image is-64x64 mr-3">
                                    @if ($adopcion->mascota->fotoPrincipal)
                                        <img src="{{ Storage::url($adopcion->mascota->fotoPrincipal->imagen_path) }}" alt="{{ $adopcion->mascota->nombre }}" style="border-radius: 4px; object-fit: cover;">
                                    @else
                                        <img src="/img/default_mascota.png" alt="Sin foto" style="border-radius: 4px;">
                                    @endif
                                </figure>
                                <div>
                                    <strong>{{ $adopcion->mascota->nombre }}</strong>
                                    <br>
                                    <small>{{ $adopcion->shelter->name }}</small>
                                </div>
                            </div>
                            <div class="level-right">
                                <span class="tag @switch($adopcion->status)
                                    @case('activa') is-success @break
                                    @case('finalizada') is-info @break
                                    @case('cancelada') is-danger @break
                                @endswitch">{{ ucfirst($adopcion->status) }}</span>
                            </div>
                        </div>

                        <p class="mt-2"><small>Aprobada: {{ $adopcion->fecha_aprobacion->format('d/m/Y') }}</small></p>

                        @if ($adopcion->status === 'activa')
                            @php
                                $hasPendingReport = $adopcion->reportes->where('status', 'pendiente')->isNotEmpty();
                            @endphp
                            <div class="buttons mt-3">
                                @if (!$hasPendingReport)
                                    <a href="{{ route('adoptante.reportes.create', $adopcion) }}" class="button is-primary is-small"><span class="icon is-small"><i class="fas fa-paper-plane"></i></span> Enviar reporte</a>
                                @else
                                    <button class="button is-small is-warning is-light" disabled><span class="icon is-small"><i class="fas fa-clock"></i></span> Tienes un reporte pendiente de revisión</button>
                                @endif
                            </div>
                        @endif

                        @if ($adopcion->reportes->isNotEmpty())
                            <details class="mt-2">
                                <summary class="has-text-grey is-size-7"><span class="icon is-small"><i class="fas fa-file-alt"></i></span> Mis reportes ({{ $adopcion->reportes->count() }})</summary>
                                @foreach ($adopcion->reportes as $reporte)
                                    <div class="box" style="padding: 0.5rem; margin-top: 0.5rem;">
                                        <p class="is-size-7">{{ $reporte->created_at->format('d/m/Y H:i') }}
                                            <span class="tag is-small ml-1 @switch($reporte->status)
                                                @case('pendiente') is-warning @break
                                                @case('revisado') is-success @break
                                                @case('requiere_atencion') is-danger @break
                                            @endswitch">{{ ucfirst($reporte->status) }}</span>
                                        </p>
                                        <p class="is-size-7 mt-1">{{ Str::limit($reporte->descripcion_reporte, 100) }}</p>
                                    </div>
                                @endforeach
                            </details>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
