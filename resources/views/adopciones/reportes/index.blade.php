@extends('layouts.app')

@section('title', 'Reportes - ' . $adopcion->mascota->nombre)

@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('refugio.adopciones.index') }}">Adopciones</a></li>
            <li class="is-active"><a href="#" aria-current="page">Reportes de {{ $adopcion->mascota->nombre }}</a></li>
        </ul>
    </nav>

    <h1 class="title">Reportes de adopción</h1>

    <div class="box mb-4">
        <p><strong>Mascota:</strong> {{ $adopcion->mascota->nombre }}</p>
        <p><strong>Adoptante:</strong> {{ $adopcion->adoptante->name }}</p>
        <p><strong>Status adopción:</strong>
            <span class="tag @switch($adopcion->status)
                @case('activa') is-success @break
                @case('finalizada') is-info @break
                @case('cancelada') is-danger @break
            @endswitch">{{ ucfirst($adopcion->status) }}</span>
        </p>
    </div>

    @if ($adopcion->reportes->isEmpty())
        <p class="has-text-grey">No hay reportes enviados por el adoptante.</p>
    @else
        @foreach ($adopcion->reportes as $reporte)
            <div class="box">
                <div class="level">
                    <div class="level-left">
                        <strong>{{ $reporte->created_at->format('d/m/Y H:i') }}</strong>
                        <span class="tag ml-2 @switch($reporte->status)
                            @case('pendiente') is-warning @break
                            @case('revisado') is-success @break
                            @case('requiere_atencion') is-danger @break
                        @endswitch">{{ ucfirst($reporte->status) }}</span>
                    </div>
                    <div class="level-right">
                        <button type="button" class="button is-small is-info is-light" onclick="document.getElementById('edit-reporte-{{ $reporte->id }}').classList.toggle('is-hidden')">Revisar</button>
                    </div>
                </div>

                <p>{{ $reporte->descripcion_reporte }}</p>

                @if ($reporte->fotos->isNotEmpty())
                    <div class="columns is-multiline is-variable is-1 mt-2">
                        @foreach ($reporte->fotos as $foto)
                            <div class="column is-narrow">
                                <figure class="image is-96x96">
                                    <img src="{{ Storage::url($foto->url) }}" alt="Foto reporte" style="border-radius: 4px; object-fit: cover;">
                                </figure>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div id="edit-reporte-{{ $reporte->id }}" class="is-hidden mt-3">
                    <form action="{{ route('refugio.adopciones.reportes.update', [$adopcion, $reporte]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="field">
                            <label class="label">Status</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="status" required>
                                        <option value="pendiente" @selected($reporte->status === 'pendiente')>Pendiente</option>
                                        <option value="revisado" @selected($reporte->status === 'revisado')>Revisado</option>
                                        <option value="requiere_atencion" @selected($reporte->status === 'requiere_atencion')>Requiere atención</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="buttons">
                            <button type="submit" class="button is-primary is-small">Actualizar</button>
                            <button type="button" class="button is-light is-small" onclick="document.getElementById('edit-reporte-{{ $reporte->id }}').classList.add('is-hidden')">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
@endsection
