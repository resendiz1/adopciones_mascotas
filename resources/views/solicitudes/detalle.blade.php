@extends('layouts.app')

@section('title', 'Detalle de Solicitud')

@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('refugio.solicitudes.recibidas') }}">Solicitudes</a></li>
            <li class="is-active"><a href="#" aria-current="page">Detalle</a></li>
        </ul>
    </nav>

    <h1 class="title">Detalle de Solicitud</h1>

    <div class="columns">
        <div class="column is-half">
            <div class="box">
                <h2 class="subtitle">Mascota</h2>

                <figure class="image is-4by3 mb-3">
                    @if ($solicitud->mascota->fotoPrincipal)
                        <img src="{{ Storage::url($solicitud->mascota->fotoPrincipal->imagen_path) }}" alt="{{ $solicitud->mascota->nombre }}" style="border-radius: 4px;">
                    @else
                        <img src="/defaults/mascota-placeholder.png" alt="Sin foto" style="border-radius: 4px;">
                    @endif
                </figure>

                <table class="table is-fullwidth is-narrow">
                    <tbody>
                        <tr>
                            <td class="has-text-weight-semibold">Nombre</td>
                            <td>{{ $solicitud->mascota->nombre }}</td>
                        </tr>
                        <tr>
                            <td class="has-text-weight-semibold">Especie</td>
                            <td>{{ ucfirst($solicitud->mascota->especie) }}</td>
                        </tr>
                        @if ($solicitud->mascota->raza)
                            <tr>
                                <td class="has-text-weight-semibold">Raza</td>
                                <td>{{ $solicitud->mascota->raza }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="has-text-weight-semibold">Sexo</td>
                            <td>{{ ucfirst($solicitud->mascota->sexo) }}</td>
                        </tr>
                        <tr>
                            <td class="has-text-weight-semibold">Edad</td>
                            <td>
                                @php
                                    $años = intdiv($solicitud->mascota->edad_meses ?? 0, 12);
                                    $meses = ($solicitud->mascota->edad_meses ?? 0) % 12;
                                @endphp
                                @if ($años > 0){{ $años }} año(s) @endif
                                @if ($meses > 0){{ $meses }} mes(es) @endif
                                @if (!$solicitud->mascota->edad_meses) No especificada @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="has-text-weight-semibold">Tamaño</td>
                            <td>{{ ucfirst($solicitud->mascota->tamano) }}</td>
                        </tr>
                        <tr>
                            <td class="has-text-weight-semibold">Estado</td>
                            <td>
                                <span class="tag @switch($solicitud->mascota->status)
                                    @case('disponible') is-success @break
                                    @case('pendiente') is-warning @break
                                    @case('adoptada') is-info @break
                                @endswitch">
                                    {{ ucfirst($solicitud->mascota->status) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="column is-half">
            <div class="box">
                <h2 class="subtitle">Adoptante</h2>

                <p><strong>Nombre:</strong> {{ $solicitud->adoptante->name }}</p>
                <p><strong>Email:</strong> {{ $solicitud->adoptante->email }}</p>
                <p><strong>Fecha de solicitud:</strong> {{ $solicitud->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Status:</strong>
                    <span class="tag @switch($solicitud->status)
                        @case('pendiente') is-warning @break
                        @case('aprobada') is-success @break
                        @case('rechazada') is-danger @break
                    @endswitch">
                        {{ ucfirst($solicitud->status) }}
                    </span>
                </p>

                @if ($solicitud->mensaje)
                    <div class="mt-3">
                        <p class="has-text-weight-bold">Mensaje inicial:</p>
                        <p>{{ $solicitud->mensaje }}</p>
                    </div>
                @endif
            </div>

            @if ($solicitud->cuestionario)
                <div class="box">
                    <h2 class="subtitle">Cuestionario</h2>

                    <table class="table is-fullwidth is-narrow">
                        <tbody>
                            <tr>
                                <td class="has-text-weight-semibold">Tipo de vivienda</td>
                                <td>{{ ucfirst($solicitud->cuestionario->tipo_vivienda) }}</td>
                            </tr>
                            <tr>
                                <td class="has-text-weight-semibold">Tiene patio</td>
                                <td>{{ $solicitud->cuestionario->tiene_patio ? 'Sí' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td class="has-text-weight-semibold">Otras mascotas</td>
                                <td>{{ $solicitud->cuestionario->otras_mascotas ? 'Sí' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td class="has-text-weight-semibold">Miembros de familia</td>
                                <td>{{ $solicitud->cuestionario->miembros_familia }}</td>
                            </tr>
                            <tr>
                                <td class="has-text-weight-semibold">Experiencia</td>
                                <td>{{ $solicitud->cuestionario->experiencia_con_mascotas }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($solicitud->motivo_rechazo)
                <div class="notification is-danger is-light">
                    <p class="has-text-weight-bold">Motivo de rechazo:</p>
                    <p>{{ $solicitud->motivo_rechazo }}</p>
                </div>
            @endif

            @if ($solicitud->status === 'pendiente')
                @if ($solicitud->cuestionario)
                    <div class="buttons">
                        <form action="{{ route('refugio.solicitudes.aprobar', $solicitud) }}" method="POST" class="mr-2">
                            @csrf
                            <button type="submit" class="button is-success is-medium">Aprobar</button>
                        </form>
                        <button type="button" class="button is-danger is-medium" onclick="document.getElementById('rechazar').classList.toggle('is-hidden')">Rechazar</button>
                    </div>

                    <div id="rechazar" class="is-hidden box">
                        <form action="{{ route('refugio.solicitudes.rechazar', $solicitud) }}" method="POST">
                            @csrf
                            <div class="field">
                                <label class="label">Motivo de rechazo</label>
                                <div class="control">
                                    <textarea class="textarea" name="motivo_rechazo" rows="3" placeholder="Explica el motivo..." required></textarea>
                                </div>
                            </div>
                            <button type="submit" class="button is-danger">Confirmar rechazo</button>
                        </form>
                    </div>
                @else
                    <div class="notification is-warning is-light">
                        El adoptante aún no completa el cuestionario. No se puede aprobar hasta que esté completo.
                    </div>
                @endif
            @endif

            @if ($solicitud->status === 'aprobada' && $solicitud->adopcion)
                <div class="notification is-success is-light">
                    <p class="has-text-weight-bold">Adopción registrada</p>
                    <p><strong>Aprobada:</strong> {{ $solicitud->adopcion->fecha_aprobacion->format('d/m/Y H:i') }}</p>
                    <p><strong>Status:</strong>
                        <span class="tag @switch($solicitud->adopcion->status)
                            @case('activa') is-success @break
                            @case('finalizada') is-info @break
                            @case('cancelada') is-danger @break
                        @endswitch">
                            {{ ucfirst($solicitud->adopcion->status) }}
                        </span>
                    </p>
                    @if ($solicitud->adopcion->fecha_entrega)
                        <p><strong>Entrega:</strong> {{ $solicitud->adopcion->fecha_entrega->format('d/m/Y') }}</p>
                    @endif
                </div>

                @if ($solicitud->adopcion->status === 'activa')
                    <div class="buttons">
                        <form action="{{ route('refugio.adopciones.finalizar', $solicitud->adopcion) }}" method="POST" class="mr-2">
                            @csrf
                            <button type="submit" class="button is-info is-medium">Finalizar adopción</button>
                        </form>
                        <button type="button" class="button is-danger is-medium" onclick="document.getElementById('cancel-adopcion').classList.toggle('is-hidden')">Cancelar adopción</button>
                    </div>

                    <div id="cancel-adopcion" class="is-hidden box">
                        <form action="{{ route('refugio.adopciones.cancelar', $solicitud->adopcion) }}" method="POST">
                            @csrf
                            <div class="field">
                                <label class="label">Motivo de cancelación</label>
                                <div class="control">
                                    <textarea class="textarea" name="motivo_cancelacion" rows="3" placeholder="Explica el motivo..." required></textarea>
                                </div>
                            </div>
                            <button type="submit" class="button is-danger">Confirmar cancelación</button>
                        </form>
                    </div>
                @elseif ($solicitud->adopcion->status === 'cancelada' && $solicitud->adopcion->notas)
                    <div class="notification is-danger is-light">
                        <p class="has-text-weight-bold">Motivo de cancelación:</p>
                        <p>{{ $solicitud->adopcion->notas }}</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
