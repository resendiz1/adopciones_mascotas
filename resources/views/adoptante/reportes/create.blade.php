@extends('layouts.app')

@section('title', 'Enviar Reporte')

@section('content')
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('adoptante.adopciones.index') }}"><span class="icon is-small"><i class="fas fa-handshake"></i></span> Mis adopciones</a></li>
            <li class="is-active"><a href="#" aria-current="page">Enviar reporte</a></li>
        </ul>
    </nav>

    <h1 class="title"><span class="icon"><i class="fas fa-paper-plane"></i></span> Enviar reporte de {{ $adopcion->mascota->nombre }}</h1>

    <div class="box">
        <form action="{{ route('adoptante.reportes.store', $adopcion) }}" method="POST">
            @csrf
            <div class="field">
                <label class="label">¿Cómo está {{ $adopcion->mascota->nombre }}?</label>
                <div class="control">
                    <textarea class="textarea" name="descripcion_reporte" rows="6" placeholder="Cuéntanos cómo se está adaptando, cómo come, cómo se comporta, si tiene algún problema..." required></textarea>
                </div>
                <p class="help">Mínimo 20 caracteres. Describe el estado actual de la mascota.</p>
            </div>
            <div class="buttons">
                <button type="submit" class="button is-primary"><span class="icon is-small"><i class="fas fa-paper-plane"></i></span> Enviar reporte</button>
                <a href="{{ route('adoptante.adopciones.index') }}" class="button is-light"><span class="icon is-small"><i class="fas fa-times"></i></span> Cancelar</a>
            </div>
        </form>
    </div>
@endsection
