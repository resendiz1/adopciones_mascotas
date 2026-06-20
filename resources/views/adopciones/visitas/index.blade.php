@extends('layouts.app')

@section('title', 'Visitas - ' . $adopcion->mascota->nombre)

@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('refugio.adopciones.index') }}">Adopciones</a></li>
            <li class="is-active"><a href="#" aria-current="page">Visitas de {{ $adopcion->mascota->nombre }}</a></li>
        </ul>
    </nav>

    <h1 class="title">Visitas de seguimiento</h1>

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

    <button type="button" class="button is-primary mb-4" onclick="document.getElementById('add-visita').classList.remove('is-hidden')">Crear visita</button>

    <div id="add-visita" class="is-hidden box mb-4">
        <form action="{{ route('refugio.adopciones.visitas.store', $adopcion) }}" method="POST">
            @csrf
            <div class="field">
                <label class="label">Tipo</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select name="tipo" required>
                            <option value="post_adopcion">Post-adopción</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Fecha programada</label>
                <div class="control">
                    <input class="input" type="date" name="fecha_programada">
                </div>
            </div>
            <div class="field">
                <label class="label">Notas</label>
                <div class="control">
                    <textarea class="textarea" name="notas" rows="2" placeholder="Notas opcionales..."></textarea>
                </div>
            </div>
            <div class="buttons">
                <button type="submit" class="button is-primary">Guardar</button>
                <button type="button" class="button is-light" onclick="document.getElementById('add-visita').classList.add('is-hidden')">Cancelar</button>
            </div>
        </form>
    </div>

    @if ($adopcion->visitas->isEmpty())
        <p class="has-text-grey">No hay visitas registradas.</p>
    @else
        @foreach ($adopcion->visitas as $visita)
            <div class="box">
                <div class="level">
                    <div class="level-left">
                        <strong>Seguimiento post-adopción</strong>
                        <span class="tag ml-2 @switch($visita->status)
                            @case('pendiente') is-warning @break
                            @case('completada') is-success @break
                            @case('fallida') is-danger @break
                        @endswitch">{{ ucfirst($visita->status) }}</span>
                    </div>
                    <div class="level-right">
                        <button type="button" class="button is-small is-info is-light" onclick="document.getElementById('edit-visita-{{ $visita->id }}').classList.toggle('is-hidden')">Editar</button>
                        <form action="{{ route('refugio.adopciones.visitas.destroy', [$adopcion, $visita]) }}" method="POST" class="is-inline" onsubmit="return confirm('¿Eliminar esta visita?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="button is-small is-danger is-light">Eliminar</button>
                        </form>
                    </div>
                </div>

                @if ($visita->fecha_programada)
                    <p><small>Programada: {{ $visita->fecha_programada->format('d/m/Y') }}</small></p>
                @endif
                @if ($visita->fecha_realizada)
                    <p><small>Realizada: {{ $visita->fecha_realizada->format('d/m/Y') }}</small></p>
                @endif
                @if ($visita->notas)
                    <p><small>{{ $visita->notas }}</small></p>
                @endif

                <div id="edit-visita-{{ $visita->id }}" class="is-hidden mt-3">
                    <form action="{{ route('refugio.adopciones.visitas.update', [$adopcion, $visita]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="field">
                            <label class="label">Status</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="status" required>
                                        <option value="pendiente" @selected($visita->status === 'pendiente')>Pendiente</option>
                                        <option value="completada" @selected($visita->status === 'completada')>Completada</option>
                                        <option value="fallida" @selected($visita->status === 'fallida')>Fallida</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Fecha realizada</label>
                            <div class="control">
                                <input class="input" type="date" name="fecha_realizada" value="{{ $visita->fecha_realizada?->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Notas</label>
                            <div class="control">
                                <textarea class="textarea" name="notas" rows="2">{{ $visita->notas }}</textarea>
                            </div>
                        </div>
                        <div class="buttons">
                            <button type="submit" class="button is-primary is-small">Actualizar</button>
                            <button type="button" class="button is-light is-small" onclick="document.getElementById('edit-visita-{{ $visita->id }}').classList.add('is-hidden')">Cancelar</button>
                        </div>
                    </form>
                </div>

                    <div class="mt-3">
                        <h5 class="subtitle is-7">Fotos / Evidencia</h5>
                        <form action="{{ route('refugio.visitas.fotos.store', $visita) }}" method="POST" enctype="multipart/form-data" class="mb-2 box" style="padding: 0.75rem;">
                            @csrf
                            <div class="field">
                                <div class="file is-small">
                                    <label class="file-label">
                                        <input class="file-input" type="file" name="foto" accept="image/*" required onchange="previewFoto(this, 'preview-{{ $visita->id }}')">
                                        <span class="file-cta">
                                            <span class="file-label">Seleccionar imagen</span>
                                        </span>
                                    </label>
                                </div>
                                <input type="hidden" name="tipo" value="foto">
                            </div>
                            <div class="field">
                                <input class="input is-small" type="text" name="descripcion" placeholder="Descripción de la imagen (opcional)">
                            </div>
                            <figure id="preview-{{ $visita->id }}" class="image is-96x96 mb-2 is-hidden">
                                <img src="" alt="Preview" style="border-radius: 4px; object-fit: cover;">
                            </figure>
                            <div class="field">
                                <button type="submit" class="button is-small is-primary">Subir</button>
                            </div>
                        </form>
                        <div class="columns is-multiline is-variable is-2">
                            @foreach ($visita->fotos as $foto)
                                <div class="column is-narrow">
                                    <figure class="image is-128x128">
                                        <img src="{{ Storage::url($foto->url) }}" alt="Foto visita" style="border-radius: 4px; object-fit: cover;">
                                    </figure>
                                    @if ($foto->descripcion)
                                        <p class="is-size-7 mt-1" style="max-width: 128px;">{{ $foto->descripcion }}</p>
                                    @endif
                                    <form action="{{ route('refugio.visitas.fotos.destroy', [$visita, $foto]) }}" method="POST" class="mt-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button is-small is-danger is-light" onclick="return confirm('¿Eliminar esta foto?')">Eliminar</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
            </div>
        @endforeach
    @endif
@endsection

@push('scripts')
<script>
function previewFoto(input, previewId) {
    var preview = document.getElementById(previewId);
    var file = input.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.classList.remove('is-hidden');
            preview.querySelector('img').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
