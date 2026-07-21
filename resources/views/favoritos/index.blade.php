@extends('layouts.app')

@section('title', 'Mis Favoritos')

@section('content')
    <h1 class="title"><span class="icon"><i class="fas fa-heart"></i></span> Mis Favoritos</h1>

    @if ($favoritos->isEmpty())
        <div class="box has-text-centered">
            <p class="subtitle">No tienes mascotas favoritas.</p>
            <a href="{{ route('mascotas.public.index') }}" class="button is-primary"><span class="icon is-small"><i class="fas fa-paw"></i></span> Ver mascotas</a>
        </div>
    @else
        <div class="columns is-multiline">
            @foreach ($favoritos as $favorito)
                @php $mascota = $favorito->mascota; @endphp
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
                                    <p class="title is-5">{{ $mascota->nombre }}</p>
                                    <p class="subtitle is-6">{{ ucfirst($mascota->especie) }} · {{ ucfirst($mascota->sexo) }}</p>
                                </div>
                            </div>
                            <div class="content">
                                <div class="tags">
                                    <span class="tag is-light">{{ ucfirst($mascota->tamano) }}</span>
                                    @if ($mascota->edad_meses)
                                        <span class="tag is-light">{{ $mascota->edad_meses }} meses</span>
                                    @endif
                                </div>
                                @if ($mascota->status === 'adoptada')
                                    <span class="tag is-info">Adoptada</span>
                                @elseif ($mascota->status === 'pendiente')
                                    <span class="tag is-warning">Pendiente</span>
                                @else
                                    <span class="tag is-success">Disponible</span>
                                @endif
                            </div>
                        </div>
                        <footer class="card-footer">
                            <a href="{{ route('mascotas.public.show', $mascota) }}" class="card-footer-item"><span class="icon is-small"><i class="fas fa-eye"></i></span> Ver</a>
                            <form action="{{ route('favoritos.toggle', $mascota) }}" method="POST">
                                @csrf
                                <button class="card-footer-item has-text-danger" style="border:none; background:none; cursor:pointer;"><span class="icon is-small"><i class="fas fa-heart-broken"></i></span> Quitar</button>
                            </form>
                        </footer>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
