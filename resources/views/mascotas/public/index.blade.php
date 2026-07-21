@extends('layouts.app')

@section('title', 'Mascotas en adopción')

@section('content')
    <h1 class="title"><span class="icon"><i class="fas fa-paw"></i></span> Mascotas en adopción</h1>

    <div class="columns">
        <div class="column is-one-quarter">
            <div class="box">
                <h3 class="subtitle is-5"><span class="icon is-small"><i class="fas fa-filter"></i></span> Filtros</h3>
                <form method="GET" action="{{ route('mascotas.public.index') }}">
                    <div class="field">
                        <label class="label"><span class="icon is-small"><i class="fas fa-paw"></i></span> Especie</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select name="especie">
                                    <option value="">Todas</option>
                                    <option value="perro" @selected(request('especie') === 'perro')>Perro</option>
                                    <option value="gato" @selected(request('especie') === 'gato')>Gato</option>
                                    <option value="conejo" @selected(request('especie') === 'conejo')>Conejo</option>
                                    <option value="ave" @selected(request('especie') === 'ave')>Ave</option>
                                    <option value="otro" @selected(request('especie') === 'otro')>Otro</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label"><span class="icon is-small"><i class="fas fa-venus-mars"></i></span> Sexo</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select name="sexo">
                                    <option value="">Todos</option>
                                    <option value="macho" @selected(request('sexo') === 'macho')>Macho</option>
                                    <option value="hembra" @selected(request('sexo') === 'hembra')>Hembra</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label"><span class="icon is-small"><i class="fas fa-ruler"></i></span> Tamaño</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select name="tamano">
                                    <option value="">Todos</option>
                                    <option value="pequeno" @selected(request('tamano') === 'pequeno')>Pequeño</option>
                                    <option value="mediano" @selected(request('tamano') === 'mediano')>Mediano</option>
                                    <option value="grande" @selected(request('tamano') === 'grande')>Grande</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    @if ($ciudades->isNotEmpty())
                        <div class="field">
                            <label class="label"><span class="icon is-small"><i class="fas fa-city"></i></span> Ciudad</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="ciudad">
                                        <option value="">Todas</option>
                                        @foreach ($ciudades as $ciudad)
                                            <option value="{{ $ciudad }}" @selected(request('ciudad') === $ciudad)>{{ $ciudad }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($estados->isNotEmpty())
                        <div class="field">
                            <label class="label"><span class="icon is-small"><i class="fas fa-map"></i></span> Estado</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="estado">
                                        <option value="">Todos</option>
                                        @foreach ($estados as $estado)
                                            <option value="{{ $estado }}" @selected(request('estado') === $estado)>{{ $estado }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="field">
                        <button type="submit" class="button is-primary is-fullwidth"><span class="icon is-small"><i class="fas fa-filter"></i></span> Filtrar</button>
                    </div>

                    @if (request()->anyFilled(['especie', 'sexo', 'tamano', 'ciudad', 'estado']))
                        <div class="field">
                            <a href="{{ route('mascotas.public.index') }}" class="button is-light is-fullwidth"><span class="icon is-small"><i class="fas fa-eraser"></i></span> Limpiar filtros</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <div class="column">
            @if ($mascotas->isEmpty())
                <div class="box has-text-centered">
                    <p class="subtitle">No se encontraron mascotas disponibles.</p>
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
                                            <p class="title is-5">{{ $mascota->nombre }}</p>
                                            <p class="subtitle is-6">{{ ucfirst($mascota->especie) }} · {{ ucfirst($mascota->sexo) }}</p>
                                        </div>
                                    </div>

                                    <div class="content">
                                        <div class="tags">
                                            @if ($mascota->raza)
                                                <span class="tag is-light">{{ $mascota->raza }}</span>
                                            @endif
                                            @if ($mascota->edad_meses)
                                                <span class="tag is-light">{{ $mascota->edad_meses }} meses</span>
                                            @endif
                                            <span class="tag is-light">{{ ucfirst($mascota->tamano) }}</span>
                                        </div>

                                        @if ($mascota->shelter->ciudad || $mascota->shelter->estado)
                                            <p class="is-size-7 has-text-grey">
                                                <span class="icon is-small"><i class="fas fa-map-marker-alt"></i></span> {{ $mascota->shelter->ciudad }}{{ $mascota->shelter->ciudad && $mascota->shelter->estado ? ', ' : '' }}{{ $mascota->shelter->estado }}
                                            </p>
                                        @endif

                                        <span class="tag is-success is-light">Disponible</span>
                                    </div>
                                </div>
                                <footer class="card-footer">
                                    <a href="{{ route('mascotas.public.show', $mascota) }}" class="card-footer-item has-text-primary"><span class="icon is-small"><i class="fas fa-eye"></i></span> Ver más</a>
                                </footer>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
