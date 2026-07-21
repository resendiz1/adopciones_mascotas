@extends('layouts.app')

@section('title', 'Fotos del reporte')

@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('adoptante.adopciones.index') }}"><span class="icon is-small"><i class="fas fa-handshake"></i></span> Mis adopciones</a></li>
            <li class="is-active"><a href="#" aria-current="page">Fotos del reporte</a></li>
        </ul>
    </nav>

    <h1 class="title"><span class="icon"><i class="fas fa-images"></i></span> Fotos del reporte</h1>

    <div class="box mb-4">
        <p><strong>Mascota:</strong> {{ $reporte->adopcion->mascota->nombre }}</p>
        <p><strong>Reporte enviado:</strong> {{ $reporte->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Status:</strong>
            <span class="tag @switch($reporte->status)
                @case('pendiente') is-warning @break
                @case('revisado') is-success @break
                @case('requiere_atencion') is-danger @break
            @endswitch">{{ ucfirst($reporte->status) }}</span>
        </p>
    </div>

    <div class="box">
        <h3 class="subtitle"><span class="icon is-small"><i class="fas fa-camera"></i></span> Subir fotos</h3>
        <form action="{{ route('adoptante.reportes.fotos.store', $reporte) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="field has-addons">
                <div class="control is-expanded">
                    <input class="input" type="file" name="foto" accept="image/*" required>
                    <input type="hidden" name="tipo" value="foto">
                </div>
                <div class="control">
                    <button type="submit" class="button is-primary"><span class="icon is-small"><i class="fas fa-upload"></i></span> Subir</button>
                </div>
            </div>
        </form>

        @if ($reporte->fotos->isNotEmpty())
            <h4 class="subtitle is-6 mt-4"><span class="icon is-small"><i class="fas fa-images"></i></span> Fotos subidas</h4>
            <div class="columns is-multiline is-variable is-2">
                @foreach ($reporte->fotos as $foto)
                    <div class="column is-narrow">
                        <figure class="image is-128x128">
                            <img src="{{ Storage::url($foto->url) }}" alt="Foto" style="border-radius: 4px; object-fit: cover;">
                        </figure>
                        <form action="{{ route('adoptante.reportes.fotos.destroy', [$reporte, $foto]) }}" method="POST" class="mt-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="button is-small is-danger is-light" onclick="return confirm('¿Eliminar esta foto?')"><span class="icon is-small"><i class="fas fa-trash-alt"></i></span> Eliminar</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('adoptante.adopciones.index') }}" class="button is-primary"><span class="icon is-small"><i class="fas fa-arrow-left"></i></span> Volver a mis adopciones</a>
        </div>
    </div>
@endsection
