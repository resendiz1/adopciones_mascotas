@extends('layouts.app')

@section('title', 'Refugios')

@section('content')
    <h1 class="title">Refugios</h1>

    <table class="table is-fullwidth is-hoverable">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Ciudad</th>
                <th>Estado</th>
                <th>Teléfono</th>
                <th>Mascotas</th>
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
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
