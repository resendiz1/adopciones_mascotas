@extends('layouts.app')

@section('title', 'Adopciones')

@section('content')
    <h1 class="title">Adopciones</h1>

    <table class="table is-fullwidth is-hoverable">
        <thead>
            <tr>
                <th>Mascota</th>
                <th>Adoptante</th>
                <th>Refugio</th>
                <th>Aprobación</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($adopciones as $adopcion)
                <tr>
                    <td>
                        <div class="level">
                            <div class="level-item">
                                <figure class="image is-48x48">
                                    @if ($adopcion->mascota->fotoPrincipal)
                                        <img src="{{ Storage::url($adopcion->mascota->fotoPrincipal->imagen_path) }}" alt="{{ $adopcion->mascota->nombre }}" style="border-radius: 4px; object-fit: cover;">
                                    @else
                                        <img src="/defaults/mascota-placeholder.png" alt="Sin foto" style="border-radius: 4px;">
                                    @endif
                                </figure>
                            </div>
                            <div class="level-item">{{ $adopcion->mascota->nombre }}</div>
                        </div>
                    </td>
                    <td>{{ $adopcion->adoptante->name }}<br><small>{{ $adopcion->adoptante->email }}</small></td>
                    <td>{{ $adopcion->shelter?->name ?? '—' }}</td>
                    <td>{{ $adopcion->fecha_aprobacion?->format('d/m/Y') ?? '—' }}</td>
                    <td>
                        <span class="tag @switch($adopcion->status)
                            @case('activa') is-success @break
                            @case('finalizada') is-info @break
                            @case('cancelada') is-danger @break
                        @endswitch">{{ ucfirst($adopcion->status) }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
