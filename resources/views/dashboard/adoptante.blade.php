@extends('layouts.app')

@section('title', 'Dashboard Adoptante')

@section('content')
    <h1 class="title">Dashboard Adoptante</h1>

    <div class="columns">
        <div class="column is-one-quarter">
            <div class="box">
                <h3 class="subtitle is-5">Filtros</h3>
                <form method="GET" action="{{ route('dashboard.adoptante') }}">
                    <div class="field">
                        <label class="label">Especie</label>
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
                        <label class="label">Sexo</label>
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
                        <label class="label">Tamaño</label>
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
                            <label class="label">Ciudad</label>
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
                            <label class="label">Estado</label>
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
                        <button type="submit" class="button is-primary is-fullwidth">Filtrar</button>
                    </div>

                    @if (request()->anyFilled(['especie', 'sexo', 'tamano', 'ciudad', 'estado']))
                        <div class="field">
                            <a href="{{ route('dashboard.adoptante') }}" class="button is-light is-fullwidth">Limpiar filtros</a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="box">
                <h3 class="subtitle is-5">Menú</h3>
                <aside class="menu">
                    <ul class="menu-list">
                        <li><a href="{{ route('favoritos.index') }}">Mis favoritos</a></li>
                        <li><a href="{{ route('solicitudes.mis-solicitudes') }}">Mis solicitudes</a></li>
                    </ul>
                </aside>
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
                                            <img src="/defaults/mascota-placeholder.png" alt="Sin foto">
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
                                                {{ $mascota->shelter->ciudad }}{{ $mascota->shelter->ciudad && $mascota->shelter->estado ? ', ' : '' }}{{ $mascota->shelter->estado }}
                                            </p>
                                        @endif

                                        <p><strong>{{ $mascota->shelter->name }}</strong></p>
                                    </div>
                                </div>
                                <footer class="card-footer">
                                    <a href="{{ route('mascotas.public.show', $mascota) }}" class="card-footer-item has-text-primary">Ver detalle</a>
                                </footer>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
