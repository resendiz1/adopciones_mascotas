@extends('layouts.app')

@section('title', 'Solicitudes Recibidas')

@section('content')
    <h1 class="title"><span class="icon"><i class="fas fa-file-alt"></i></span> Solicitudes Recibidas</h1>

    @if ($solicitudes->isEmpty())
        <div class="box has-text-centered">
            <p class="subtitle">No has recibido solicitudes de adopción.</p>
        </div>
    @else
        <table class="table is-fullwidth is-hoverable">
            <thead>
                <tr>
                    <th>Mascota</th>
                    <th>Adoptante</th>
                    <th>Teléfono</th>
                    <th>Fecha</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($solicitudes as $solicitud)
                    <tr>
                        <td>
                            <div class="level">
                                <div class="level-item">
                                    <figure class="image is-48x48">
                                        @if ($solicitud->mascota->fotoPrincipal)
                                            <img src="{{ Storage::url($solicitud->mascota->fotoPrincipal->imagen_path) }}" alt="{{ $solicitud->mascota->nombre }}" style="border-radius: 4px;">
                                        @else
                                            <img src="/img/default_mascota.png" alt="Sin foto" style="border-radius: 4px;">
                                        @endif
                                    </figure>
                                </div>
                                <div class="level-item">
                                    {{ $solicitud->mascota->nombre }}
                                </div>
                            </div>
                        </td>
                        <td>{{ $solicitud->adoptante->name }}</td>
                        <td>{{ $solicitud->adoptante->email }}</td>
                        <td>{{ $solicitud->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="tag @switch($solicitud->status)
                                @case('pendiente') is-warning @break
                                @case('aprobada') is-success @break
                                @case('rechazada') is-danger @break
                            @endswitch">
                                {{ ucfirst($solicitud->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('refugio.solicitudes.detalle', $solicitud) }}" class="button is-small is-info"><span class="icon is-small"><i class="fas fa-eye"></i></span> Ver detalle</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
