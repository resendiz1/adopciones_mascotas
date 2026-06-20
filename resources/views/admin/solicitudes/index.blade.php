@extends('layouts.app')

@section('title', 'Solicitudes')

@section('content')
    <h1 class="title">Solicitudes</h1>

    <table class="table is-fullwidth is-hoverable">
        <thead>
            <tr>
                <th>Mascota</th>
                <th>Adoptante</th>
                <th>Refugio</th>
                <th>Status</th>
                <th>Fecha</th>
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
                                        <img src="{{ Storage::url($solicitud->mascota->fotoPrincipal->imagen_path) }}" alt="{{ $solicitud->mascota->nombre }}" style="border-radius: 4px; object-fit: cover;">
                                    @else
                                        <img src="/defaults/mascota-placeholder.png" alt="Sin foto" style="border-radius: 4px;">
                                    @endif
                                </figure>
                            </div>
                            <div class="level-item">{{ $solicitud->mascota->nombre }}</div>
                        </div>
                    </td>
                    <td>{{ $solicitud->adoptante->name }}<br><small>{{ $solicitud->adoptante->email }}</small></td>
                    <td>{{ $solicitud->mascota->shelter?->name ?? '—' }}</td>
                    <td>
                        <span class="tag @switch($solicitud->status)
                            @case('pendiente') is-warning @break
                            @case('aprobada') is-success @break
                            @case('rechazada') is-danger @break
                        @endswitch">{{ ucfirst($solicitud->status) }}</span>
                    </td>
                    <td>{{ $solicitud->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
