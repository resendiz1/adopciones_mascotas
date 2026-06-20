@extends('layouts.app')

@section('title', 'Adopciones')

@section('content')
    <h1 class="title">Adopciones</h1>

    @if ($adopciones->isEmpty())
        <div class="box has-text-centered">
            <p class="subtitle">No hay adopciones registradas aún.</p>
        </div>
    @else
        <table class="table is-fullwidth is-hoverable">
            <thead>
                <tr>
                    <th>Mascota</th>
                    <th>Adoptante</th>
                    <th>Aprobación</th>
                    <th>Status</th>
                    <th>Seguimiento</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($adopciones as $adopcion)
                    <tr>
                        <td>
                            <div class="level">
                                <div class="level-item">
                                    <figure class="image is-48x48">
                                        @if ($adopcion->mascota->fotoPrincipal)
                                            <img src="{{ Storage::url($adopcion->mascota->fotoPrincipal->imagen_path) }}" alt="{{ $adopcion->mascota->nombre }}" style="border-radius: 4px;">
                                        @else
                                            <img src="/defaults/mascota-placeholder.png" alt="Sin foto" style="border-radius: 4px;">
                                        @endif
                                    </figure>
                                </div>
                                <div class="level-item">
                                    {{ $adopcion->mascota->nombre }}
                                </div>
                            </div>
                        </td>
                        <td>{{ $adopcion->adoptante->name }}<br><small>{{ $adopcion->adoptante->email }}</small></td>
                        <td>{{ $adopcion->fecha_aprobacion->format('d/m/Y') }}</td>
                        <td>
                            <span class="tag @switch($adopcion->status)
                                @case('activa') is-success @break
                                @case('finalizada') is-info @break
                                @case('cancelada') is-danger @break
                            @endswitch">
                                {{ ucfirst($adopcion->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="buttons are-small">
                                <a href="{{ route('refugio.adopciones.visitas.index', $adopcion) }}" class="button is-small is-info is-light">Visitas</a>
                                <a href="{{ route('refugio.adopciones.reportes.index', $adopcion) }}" class="button is-small is-warning is-light">Reportes</a>
                            </div>
                        </td>
                        <td>
                            @if ($adopcion->status === 'activa')
                                <div class="buttons are-small">
                                    <form action="{{ route('refugio.adopciones.finalizar', $adopcion) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="button is-info is-small">Finalizar</button>
                                    </form>
                                    <button type="button" class="button is-danger is-small" onclick="document.getElementById('cancel-{{ $adopcion->id }}').classList.toggle('is-hidden')">Cancelar</button>
                                </div>
                                <div id="cancel-{{ $adopcion->id }}" class="is-hidden box" style="margin-top: 0.5rem;">
                                    <form action="{{ route('refugio.adopciones.cancelar', $adopcion) }}" method="POST">
                                        @csrf
                                        <div class="field">
                                            <label class="label">Motivo de cancelación</label>
                                            <div class="control">
                                                <textarea class="textarea" name="motivo_cancelacion" rows="2" placeholder="Explica el motivo..." required></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" class="button is-danger is-small">Confirmar cancelación</button>
                                    </form>
                                </div>
                            @elseif ($adopcion->status === 'cancelada' && $adopcion->notas)
                                <p><small>{{ $adopcion->notas }}</small></p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
