@extends('layouts.app')

@section('title', 'Mascotas')

@section('content')
    <h1 class="title">Mascotas</h1>

    <table class="table is-fullwidth is-hoverable">
        <thead>
            <tr>
                <th>Mascota</th>
                <th>Refugio</th>
                <th>Especie</th>
                <th>Sexo</th>
                <th>Status</th>
                <th>Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mascotas as $mascota)
                <tr>
                    <td>
                        <div class="level">
                            <div class="level-item">
                                <figure class="image is-48x48">
                                    @if ($mascota->fotoPrincipal)
                                        <img src="{{ Storage::url($mascota->fotoPrincipal->imagen_path) }}" alt="{{ $mascota->nombre }}" style="border-radius: 4px; object-fit: cover;">
                                    @else
                                        <img src="/defaults/mascota-placeholder.png" alt="Sin foto" style="border-radius: 4px;">
                                    @endif
                                </figure>
                            </div>
                            <div class="level-item">{{ $mascota->nombre }}</div>
                        </div>
                    </td>
                    <td>{{ $mascota->shelter?->name ?? '—' }}</td>
                    <td>{{ ucfirst($mascota->especie) }}</td>
                    <td>{{ ucfirst($mascota->sexo) }}</td>
                    <td>
                        <span class="tag @switch($mascota->status)
                            @case('disponible') is-success @break
                            @case('pendiente') is-warning @break
                            @case('adoptada') is-info @break
                        @endswitch">{{ ucfirst($mascota->status) }}</span>
                    </td>
                    <td>{{ $mascota->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
