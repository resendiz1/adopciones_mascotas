@extends('layouts.app')

@section('title', 'Refugios')

@section('content')
    <h1 class="title"><span class="icon"><i class="fas fa-building"></i></span> Refugios</h1>

    @if (session('success'))
        <div class="notification is-success is-light">
            {{ session('success') }}
        </div>
    @endif

    <table class="table is-fullwidth is-hoverable">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Ciudad</th>
                <th>Estado</th>
                <th>Teléfono</th>
                <th>Mascotas</th>
                <th>Status</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($refugios as $refugio)
                <tr>
                    <td>{{ $refugio->name }}</td>
                    <td>{{ $refugio->user->name }}<br><small>{{ $refugio->user->email }}</small></td>
                    <td>{{ $refugio->ciudad ?? '—' }}</td>
                    <td>{{ $refugio->estado ?? '—' }}</td>
                    <td>{{ $refugio->phone ?? '—' }}</td>
                    <td>{{ $refugio->mascotas_count }}</td>
                    <td>
                        @if ($refugio->status === 'aprobado')
                            <span class="tag is-success"><span class="icon is-small"><i class="fas fa-check-circle"></i></span> Aprobado</span>
                        @elseif ($refugio->status === 'pendiente')
                            <span class="tag is-warning"><span class="icon is-small"><i class="fas fa-clock"></i></span> Pendiente</span>
                        @else
                            <span class="tag is-danger"><span class="icon is-small"><i class="fas fa-times-circle"></i></span> Rechazado</span>
                        @endif
                    </td>
                    <td>
                        @if ($refugio->status === 'pendiente')
                            <div class="buttons">
                                <form action="{{ route('admin.refugios.aprobar', $refugio) }}" method="POST">
                                    @csrf
<button class="button is-success is-small"><span class="icon is-small"><i class="fas fa-check"></i></span> Aprobar</button>
                                </form>
                                <form action="{{ route('admin.refugios.rechazar', $refugio) }}" method="POST">
                                    @csrf
                                    <button class="button is-danger is-small"><span class="icon is-small"><i class="fas fa-times"></i></span> Rechazar</button>
                                </form>
                            </div>
                        @elseif ($refugio->status === 'rechazado')
                            <form action="{{ route('admin.refugios.aprobar', $refugio) }}" method="POST">
                                @csrf
                                <button class="button is-success is-small">Aprobar</button>
                            </form>
                        @else
                            <span class="has-text-grey-light">—</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
