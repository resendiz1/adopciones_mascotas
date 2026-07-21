@extends('layouts.app')

@section('title', 'Salud - ' . $mascota->nombre)

@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('refugio.mascotas.index') }}">Mis mascotas</a></li>
            <li class="is-active"><a href="#" aria-current="page">Salud de {{ $mascota->nombre }}</a></li>
        </ul>
    </nav>

    <h1 class="title"><span class="icon"><i class="fas fa-heartbeat"></i></span> Salud de {{ $mascota->nombre }}</h1>

    <div class="columns">
        <div class="column is-half">
            <div class="box">
                <div class="level">
                    <div class="level-left">
                        <h2 class="subtitle"><span class="icon is-small"><i class="fas fa-syringe"></i></span> Vacunas</h2>
                    </div>
                    <div class="level-right">
                        <button type="button" class="button is-primary is-small" onclick="document.getElementById('add-vacuna').classList.remove('is-hidden')"><span class="icon is-small"><i class="fas fa-plus"></i></span> Agregar vacuna</button>
                    </div>
                </div>

                <div id="add-vacuna" class="is-hidden box mb-4">
                    <form action="{{ route('refugio.mascotas.vacunas.store', $mascota) }}" method="POST">
                        @csrf
                        <div class="field">
                            <label class="label">Vacuna</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="vacuna_id" required>
                                        <option value="">Seleccionar vacuna...</option>
                                        @foreach ($vacunasDisponibles as $vacuna)
                                            <option value="{{ $vacuna->id }}">{{ $vacuna->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column">
                                <div class="field">
                                    <label class="label">Fecha de aplicación</label>
                                    <div class="control">
                                        <input class="input" type="date" name="fecha_aplicacion">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <label class="label">Próxima dosis</label>
                                    <div class="control">
                                        <input class="input" type="date" name="proxima_dosis">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Notas</label>
                            <div class="control">
                                <textarea class="textarea" name="notas" rows="2" placeholder="Notas opcionales..."></textarea>
                            </div>
                        </div>
                        <div class="buttons">
                            <button type="submit" class="button is-primary"><span class="icon is-small"><i class="fas fa-save"></i></span> Guardar</button>
                            <button type="button" class="button is-light" onclick="document.getElementById('add-vacuna').classList.add('is-hidden')"><span class="icon is-small"><i class="fas fa-times"></i></span> Cancelar</button>
                        </div>
                    </form>
                </div>

                @forelse ($mascota->vacunas as $vacuna)
                    <div class="box">
                        <div class="level">
                            <div class="level-left">
                                <strong>{{ $vacuna->vacuna->nombre }}</strong>
                            </div>
                            <div class="level-right">
                                <button type="button" class="button is-small is-info is-light" onclick="document.getElementById('edit-vacuna-{{ $vacuna->id }}').classList.toggle('is-hidden')"><span class="icon is-small"><i class="fas fa-edit"></i></span> Editar</button>
                                <form action="{{ route('refugio.mascotas.vacunas.destroy', [$mascota, $vacuna]) }}" method="POST" class="is-inline" onsubmit="return confirm('¿Eliminar este registro de vacuna?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button is-small is-danger is-light"><span class="icon is-small"><i class="fas fa-trash-alt"></i></span> Eliminar</button>
                                </form>
                            </div>
                        </div>
                        @if ($vacuna->fecha_aplicacion)
                            <p><small>Aplicación: {{ $vacuna->fecha_aplicacion->format('d/m/Y') }}</small></p>
                        @endif
                        @if ($vacuna->proxima_dosis)
                            <p><small>Próxima dosis: {{ $vacuna->proxima_dosis->format('d/m/Y') }}</small></p>
                        @endif
                        @if ($vacuna->notas)
                            <p><small>Notas: {{ $vacuna->notas }}</small></p>
                        @endif

                        <div id="edit-vacuna-{{ $vacuna->id }}" class="is-hidden mt-3">
                            <form action="{{ route('refugio.mascotas.vacunas.update', [$mascota, $vacuna]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="field">
                                    <label class="label">Vacuna</label>
                                    <div class="control">
                                        <div class="select is-fullwidth">
                                            <select name="vacuna_id" required>
                                                @foreach ($vacunasDisponibles as $v)
                                                    <option value="{{ $v->id }}" @selected($v->id === $vacuna->vacuna_id)>{{ $v->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column">
                                        <div class="field">
                                            <label class="label">Fecha de aplicación</label>
                                            <div class="control">
                                                <input class="input" type="date" name="fecha_aplicacion" value="{{ $vacuna->fecha_aplicacion?->format('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="field">
                                            <label class="label">Próxima dosis</label>
                                            <div class="control">
                                                <input class="input" type="date" name="proxima_dosis" value="{{ $vacuna->proxima_dosis?->format('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Notas</label>
                                    <div class="control">
                                        <textarea class="textarea" name="notas" rows="2">{{ $vacuna->notas }}</textarea>
                                    </div>
                                </div>
                                <div class="buttons">
                                    <button type="submit" class="button is-primary is-small"><span class="icon is-small"><i class="fas fa-save"></i></span> Actualizar</button>
                                    <button type="button" class="button is-light is-small" onclick="document.getElementById('edit-vacuna-{{ $vacuna->id }}').classList.add('is-hidden')"><span class="icon is-small"><i class="fas fa-times"></i></span> Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="has-text-grey">No hay vacunas registradas.</p>
                @endforelse
            </div>
        </div>

        <div class="column is-half">
            <div class="box">
                <div class="level">
                    <div class="level-left">
                        <h2 class="subtitle"><span class="icon is-small"><i class="fas fa-notes-medical"></i></span> Eventos médicos</h2>
                    </div>
                    <div class="level-right">
                        <button type="button" class="button is-primary is-small" onclick="document.getElementById('add-evento').classList.remove('is-hidden')"><span class="icon is-small"><i class="fas fa-plus"></i></span> Agregar evento</button>
                    </div>
                </div>

                <div id="add-evento" class="is-hidden box mb-4">
                    <form action="{{ route('refugio.mascotas.eventos.store', $mascota) }}" method="POST">
                        @csrf
                        <div class="field">
                            <label class="label">Tipo</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="tipo" required>
                                        <option value="">Seleccionar tipo...</option>
                                        <option value="desparasitacion">Desparasitación</option>
                                        <option value="cirugia">Cirugía</option>
                                        <option value="tratamiento">Tratamiento</option>
                                        <option value="consulta">Consulta</option>
                                        <option value="observacion">Observación</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Fecha</label>
                            <div class="control">
                                <input class="input" type="date" name="fecha">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Título</label>
                            <div class="control">
                                <input class="input" type="text" name="titulo_evento" placeholder="Ej: Esterilización, Revisión general..." required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Notas</label>
                            <div class="control">
                                <textarea class="textarea" name="notas" rows="2" placeholder="Notas opcionales..."></textarea>
                            </div>
                        </div>
                        <div class="buttons">
                            <button type="submit" class="button is-primary"><span class="icon is-small"><i class="fas fa-save"></i></span> Guardar</button>
                            <button type="button" class="button is-light" onclick="document.getElementById('add-evento').classList.add('is-hidden')"><span class="icon is-small"><i class="fas fa-times"></i></span> Cancelar</button>
                        </div>
                    </form>
                </div>

                @forelse ($mascota->eventosMedicos as $evento)
                    <div class="box">
                        <div class="level">
                            <div class="level-left">
                                <strong>{{ $evento->titulo_evento }}</strong>
                                <span class="tag is-light ml-2">{{ ucfirst($evento->tipo) }}</span>
                            </div>
                            <div class="level-right">
                                <button type="button" class="button is-small is-info is-light" onclick="document.getElementById('edit-evento-{{ $evento->id }}').classList.toggle('is-hidden')"><span class="icon is-small"><i class="fas fa-edit"></i></span> Editar</button>
                                <form action="{{ route('refugio.mascotas.eventos.destroy', [$mascota, $evento]) }}" method="POST" class="is-inline" onsubmit="return confirm('¿Eliminar este evento?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button is-small is-danger is-light"><span class="icon is-small"><i class="fas fa-trash-alt"></i></span> Eliminar</button>
                                </form>
                            </div>
                        </div>
                        @if ($evento->fecha)
                            <p><small>Fecha: {{ $evento->fecha->format('d/m/Y') }}</small></p>
                        @endif
                        @if ($evento->notas)
                            <p><small>{{ $evento->notas }}</small></p>
                        @endif

                        <div id="edit-evento-{{ $evento->id }}" class="is-hidden mt-3">
                            <form action="{{ route('refugio.mascotas.eventos.update', [$mascota, $evento]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="field">
                                    <label class="label">Tipo</label>
                                    <div class="control">
                                        <div class="select is-fullwidth">
                                            <select name="tipo" required>
                                                <option value="desparasitacion" @selected($evento->tipo === 'desparasitacion')>Desparasitación</option>
                                                <option value="cirugia" @selected($evento->tipo === 'cirugia')>Cirugía</option>
                                                <option value="tratamiento" @selected($evento->tipo === 'tratamiento')>Tratamiento</option>
                                                <option value="consulta" @selected($evento->tipo === 'consulta')>Consulta</option>
                                                <option value="observacion" @selected($evento->tipo === 'observacion')>Observación</option>
                                                <option value="otro" @selected($evento->tipo === 'otro')>Otro</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Fecha</label>
                                    <div class="control">
                                        <input class="input" type="date" name="fecha" value="{{ $evento->fecha?->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Título</label>
                                    <div class="control">
                                        <input class="input" type="text" name="titulo_evento" value="{{ $evento->titulo_evento }}" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Notas</label>
                                    <div class="control">
                                        <textarea class="textarea" name="notas" rows="2">{{ $evento->notas }}</textarea>
                                    </div>
                                </div>
                                <div class="buttons">
                                    <button type="submit" class="button is-primary is-small"><span class="icon is-small"><i class="fas fa-save"></i></span> Actualizar</button>
                                    <button type="button" class="button is-light is-small" onclick="document.getElementById('edit-evento-{{ $evento->id }}').classList.add('is-hidden')"><span class="icon is-small"><i class="fas fa-times"></i></span> Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="has-text-grey">No hay eventos médicos registrados.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
