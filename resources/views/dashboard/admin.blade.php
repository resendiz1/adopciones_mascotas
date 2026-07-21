@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h1 class="title"><span class="icon"><i class="fas fa-tachometer-alt"></i></span> Panel de Administración</h1>

    <div class="columns is-multiline mt-4">
        <div class="column is-one-third">
            <div class="box has-text-centered">
                <p class="heading"><span class="icon"><i class="fas fa-users"></i></span> Total Usuarios</p>
                <p class="title">{{ $totalUsers }}</p>
                <p class="is-size-7 has-text-grey">{{ $totalAdoptantes }} adoptantes · {{ $totalRefugios }} refugios</p>
            </div>
        </div>
        <div class="column is-one-third">
            <div class="box has-text-centered">
                <p class="heading"><span class="icon"><i class="fas fa-paw"></i></span> Total Mascotas</p>
                <p class="title">{{ $totalMascotas }}</p>
                <p class="is-size-7 has-text-grey">
                    <span class="has-text-success">{{ $mascotasDisponibles }} disponibles</span> ·
                    <span class="has-text-warning">{{ $mascotasPendientes }} pendientes</span> ·
                    <span class="has-text-info">{{ $mascotasAdoptadas }} adoptadas</span>
                </p>
            </div>
        </div>
        <div class="column is-one-third">
            <div class="box has-text-centered">
                <p class="heading"><span class="icon"><i class="fas fa-file-alt"></i></span> Solicitudes</p>
                <p class="title">{{ $solicitudesPendientes + $solicitudesAprobadas + $solicitudesRechazadas }}</p>
                <p class="is-size-7 has-text-grey">
                    <span class="has-text-warning">{{ $solicitudesPendientes }} pendientes</span> ·
                    <span class="has-text-success">{{ $solicitudesAprobadas }} aprobadas</span> ·
                    <span class="has-text-danger">{{ $solicitudesRechazadas }} rechazadas</span>
                </p>
            </div>
        </div>
        <div class="column is-one-third">
            <div class="box has-text-centered">
                <p class="heading"><span class="icon"><i class="fas fa-handshake"></i></span> Adopciones</p>
                <p class="title">{{ $totalAdopciones }}</p>
            </div>
        </div>
        <div class="column is-one-third">
            <div class="box has-text-centered">
                <p class="heading"><span class="icon"><i class="fas fa-building"></i></span> Refugios Pendientes</p>
                <p class="title {{ $refugiosPendientes > 0 ? 'has-text-warning' : '' }}">{{ $refugiosPendientes }}</p>
                @if ($refugiosPendientes > 0)
                    <a href="{{ route('admin.refugios') }}" class="button is-warning is-small mt-2"><span class="icon is-small"><i class="fas fa-eye"></i></span> Revisar</a>
                @endif
            </div>
        </div>
    </div>

    <div class="columns">
        @if ($adopcionesPorMes->isNotEmpty())
            <div class="column is-half">
                <div class="box">
                    <h2 class="subtitle"><span class="icon is-small"><i class="fas fa-calendar-alt"></i></span> Adopciones por mes</h2>
                    <table class="table is-fullwidth is-narrow">
                        <thead>
                            <tr>
                                <th>Mes</th>
                                <th class="has-text-right">Adopciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adopcionesPorMes as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $item->mes)->format('F Y') }}</td>
                                    <td class="has-text-right">{{ $item->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if ($refugiosTop->isNotEmpty())
            <div class="column is-half">
                <div class="box">
                    <h2 class="subtitle"><span class="icon is-small"><i class="fas fa-trophy"></i></span> Refugios con más adopciones</h2>
                    <table class="table is-fullwidth is-narrow">
                        <thead>
                            <tr>
                                <th>Refugio</th>
                                <th class="has-text-right">Adopciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($refugiosTop as $item)
                                <tr>
                                    <td>{{ $item->shelter?->name ?? 'Desconocido' }}</td>
                                    <td class="has-text-right">{{ $item->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if ($mascotasPorEspecie->isNotEmpty())
            <div class="column is-half">
                <div class="box">
                    <h2 class="subtitle"><span class="icon is-small"><i class="fas fa-paw"></i></span> Mascotas por especie</h2>
                    <table class="table is-fullwidth is-narrow">
                        <thead>
                            <tr>
                                <th>Especie</th>
                                <th class="has-text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mascotasPorEspecie as $item)
                                <tr>
                                    <td>{{ ucfirst($item->especie) }}</td>
                                    <td class="has-text-right">{{ $item->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
