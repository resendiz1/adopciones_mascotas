@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
    <h1 class="title">Usuarios</h1>

    <table class="table is-fullwidth is-hoverable">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Refugio</th>
                <th>Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        <span class="tag @switch($usuario->role)
                            @case('admin') is-danger @break
                            @case('refugio') is-primary @break
                            @case('adoptante') is-success @break
                        @endswitch">{{ ucfirst($usuario->role) }}</span>
                    </td>
                    <td>{{ $usuario->shelter?->name ?? '—' }}</td>
                    <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
