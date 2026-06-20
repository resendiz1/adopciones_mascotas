@extends('layouts.app')

@section('title', $mascota->nombre)

@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('mascotas.public.index') }}">Mascotas</a></li>
            <li class="is-active"><a href="#" aria-current="page">{{ $mascota->nombre }}</a></li>
        </ul>
    </nav>

    <div class="columns">
        <div class="column is-half">
            <figure class="image">
                @if ($mascota->fotoPrincipal)
                    <img src="{{ Storage::url($mascota->fotoPrincipal->imagen_path) }}" alt="{{ $mascota->nombre }}" style="border-radius: 8px;">
                @else
                    <img src="/defaults/mascota-placeholder.png" alt="Sin foto" style="border-radius: 8px;">
                @endif
            </figure>
        </div>

        <div class="column is-half">
            <h1 class="title">{{ $mascota->nombre }}</h1>
            <span class="tag is-medium mb-4 @switch($mascota->status)
                @case('disponible') is-success is-light @break
                @case('pendiente') is-warning is-light @break
                @case('adoptada')  is-info is-light @break
            @endswitch">
                {{ ucfirst($mascota->status) }}
            </span>

            <div class="box">
                <table class="table is-fullwidth is-narrow">
                    <tbody>
                        <tr>
                            <td class="has-text-weight-semibold">Especie</td>
                            <td>{{ ucfirst($mascota->especie) }}</td>
                        </tr>
                        @if ($mascota->raza)
                            <tr>
                                <td class="has-text-weight-semibold">Raza</td>
                                <td>{{ $mascota->raza }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="has-text-weight-semibold">Sexo</td>
                            <td>{{ ucfirst($mascota->sexo) }}</td>
                        </tr>
                        <tr>
                            <td class="has-text-weight-semibold">Edad</td>
                            <td>
                                @php
                                    $años = intdiv($mascota->edad_meses ?? 0, 12);
                                    $meses = ($mascota->edad_meses ?? 0) % 12;
                                @endphp
                                @if ($años > 0){{ $años }} año(s) @endif
                                @if ($meses > 0){{ $meses }} mes(es) @endif
                                @if (!$mascota->edad_meses) No especificada @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="has-text-weight-semibold">Tamaño</td>
                            <td>{{ ucfirst($mascota->tamano) }}</td>
                        </tr>
                        @if ($mascota->peso)
                            <tr>
                                <td class="has-text-weight-semibold">Peso</td>
                                <td>{{ $mascota->peso }} kg</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="has-text-weight-semibold">Esterilizado</td>
                            <td>{{ $mascota->esterilizado ? 'Sí' : 'No' }}</td>
                        </tr>
                        <tr>
                            <td class="has-text-weight-semibold">Desparasitado</td>
                            <td>{{ $mascota->desparasitado ? 'Sí' : 'No' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="box">
                <h3 class="subtitle is-5">Descripción</h3>
                <p>{{ $mascota->descripcion }}</p>
            </div>

            <div class="box">
                <h3 class="subtitle is-5">Refugio</h3>
                <p><strong>{{ $mascota->shelter->name }}</strong></p>
                @if ($mascota->shelter->ciudad || $mascota->shelter->estado)
                    <p>
                        📍 {{ $mascota->shelter->ciudad }}{{ $mascota->shelter->ciudad && $mascota->shelter->estado ? ', ' : '' }}{{ $mascota->shelter->estado }}
                    </p>
                @endif
                @if ($mascota->shelter->phone)
                    <p>📞 {{ $mascota->shelter->phone }}</p>
                @endif
                <p class="mt-3 has-text-grey is-size-7">{{ $mascota->shelter->description }}</p>
            </div>

            @if ($mascota->vacunas->isNotEmpty() || $mascota->eventosMedicos->isNotEmpty())
                <div class="box">
                    <h3 class="subtitle is-5">Historial médico</h3>

                    @if ($mascota->vacunas->isNotEmpty())
                        <h4 class="subtitle is-6 mt-3">Vacunas</h4>
                        <table class="table is-fullwidth is-narrow">
                            <thead>
                                <tr>
                                    <th>Vacuna</th>
                                    <th>Aplicación</th>
                                    <th>Próxima dosis</th>
                                    <th>Notas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mascota->vacunas as $vacuna)
                                    <tr>
                                        <td>{{ $vacuna->vacuna->nombre }}</td>
                                        <td>{{ $vacuna->fecha_aplicacion?->format('d/m/Y') ?? '—' }}</td>
                                        <td>{{ $vacuna->proxima_dosis?->format('d/m/Y') ?? '—' }}</td>
                                        <td>{{ $vacuna->notas ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    @if ($mascota->eventosMedicos->isNotEmpty())
                        <h4 class="subtitle is-6 mt-3">Eventos médicos</h4>
                        <table class="table is-fullwidth is-narrow">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Título</th>
                                    <th>Notas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mascota->eventosMedicos as $evento)
                                    <tr>
                                        <td>{{ $evento->fecha?->format('d/m/Y') ?? '—' }}</td>
                                        <td>{{ ucfirst($evento->tipo) }}</td>
                                        <td>{{ $evento->titulo_evento }}</td>
                                        <td>{{ $evento->notas ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            @endif

            @auth
                @if (Auth::user()->role === 'adoptante')
                    <div class="buttons">
                        <form action="{{ route('solicitudes.create', $mascota) }}" method="POST" class="mr-2">
                            @csrf
                            <button type="submit" class="button is-primary is-medium" @if($mascota->status !== 'disponible') disabled @endif>
                                @if($mascota->status === 'disponible')
                                    Quiero adoptar
                                @else
                                    No disponible
                                @endif
                            </button>
                        </form>

                        <form action="{{ route('favoritos.toggle', $mascota) }}" method="POST">
                            @csrf
                            <button type="submit" class="button is-info is-light is-medium">
                                @php $esFavorito = Auth::user()->favoritos()->where('mascota_id', $mascota->id)->exists(); @endphp
                                {{ $esFavorito ? 'Quitar de favoritos' : 'Guardar en favoritos' }}
                            </button>
                        </form>
                    </div>
                @elseif (Auth::user()->role === 'refugio')
                    <div class="notification is-info is-light">
                        Esta es una de tus mascotas publicadas.
                        <a href="{{ route('refugio.mascotas.index') }}">Ir a mis mascotas</a>
                    </div>
                @endif
            @else
                <div class="notification is-info is-light">
                    <a href="{{ route('login') }}">Inicia sesión</a> como adoptante para solicitar la adopción.
                </div>
            @endauth
        </div>
    </div>
@endsection
