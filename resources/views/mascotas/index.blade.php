@extends('layouts.app')

@section('title', 'Mis Mascotas')

@section('content')
    <div class="level">
        <div class="level-left">
            <h1 class="title"><span class="icon"><i class="fas fa-paw"></i></span> Mis Mascotas</h1>
        </div>
        <div class="level-right">
            <a href="{{ route('refugio.mascotas.create') }}" class="button is-primary"><span class="icon is-small"><i class="fas fa-plus"></i></span> Registrar mascota</a>
        </div>
    </div>

    @if ($mascotas->isEmpty())
        <div class="box has-text-centered">
            <p class="subtitle">Aún no tienes mascotas registradas.</p>
            <a href="{{ route('refugio.mascotas.create') }}" class="button is-primary"><span class="icon is-small"><i class="fas fa-plus"></i></span> Registrar primera mascota</a>
        </div>
    @else
        <div class="columns is-multiline">
            @foreach ($mascotas as $mascota)
                <div class="column is-one-third">
                    <div class="card">
                        <div class="card-image">
                            <figure class="image is-4by3">
                                @if ($mascota->fotoPrincipal)
                                    <img src="{{ Storage::url($mascota->fotoPrincipal->imagen_path) }}" alt="{{ $mascota->nombre }}">
                                @else
                                    <img src="/img/default_mascota.png" alt="Sin foto">
                                @endif
                            </figure>
                        </div>
                        <div class="card-content">
                            <div class="media">
                                <div class="media-content">
                                    <p class="title is-4">{{ $mascota->nombre }}</p>
                                    <p class="subtitle is-6">{{ $mascota->especie }} - {{ $mascota->sexo }}</p>
                                </div>
                            </div>

                            <div class="content">
                                <span class="tag @switch($mascota->status)
                                    @case('disponible') is-success @break
                                    @case('pendiente') is-warning @break
                                    @case('adoptada') is-info @break
                                @endswitch">
                                    {{ $mascota->status }}
                                </span>
                                <span class="tag is-light">{{ ucfirst($mascota->tamano) }}</span>
                                @if ($mascota->edad_meses)
                                    <span class="tag is-light">{{ $mascota->edad_meses }} meses</span>
                                @endif
                            </div>
                        </div>
                        <footer class="card-footer">
                            <a href="{{ route('refugio.mascotas.edit', $mascota) }}" class="card-footer-item"><span class="icon is-small"><i class="fas fa-edit"></i></span> Editar</a>
                            <a href="{{ route('refugio.mascotas.salud', $mascota) }}" class="card-footer-item"><span class="icon is-small"><i class="fas fa-heartbeat"></i></span> Salud</a>
                            <form action="{{ route('refugio.mascotas.destroy', $mascota) }}" method="POST" onsubmit="return confirm('¿Eliminar esta mascota?')">
                                @csrf
                                @method('DELETE')
                                <button class="card-footer-item" style="border:none; background:none; cursor:pointer; color:#f14668;"><span class="icon is-small"><i class="fas fa-trash-alt"></i></span> Eliminar</button>
                            </form>
                        </footer>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
