@extends('layouts.app')

@section('title', 'Cuestionario de adopción')

@section('content')
    <h1 class="title">Cuestionario de adopción</h1>

    <div class="box">
        <p><strong>Mascota:</strong> {{ $solicitud->mascota->nombre }}</p>
    </div>

    <div class="columns">
        <div class="column is-half">
            <form method="POST" action="{{ route('solicitudes.guardar-cuestionario', $solicitud) }}">
                @csrf

                <div class="box">
                    <div class="field">
                        <label class="label">Tipo de vivienda <span class="has-text-danger">*</span></label>
                        <div class="control">
                            <div class="select is-fullwidth @error('tipo_vivienda') is-danger @enderror">
                                <select name="tipo_vivienda" required>
                                    <option value="">Selecciona</option>
                                    <option value="departamento" @selected(old('tipo_vivienda') === 'departamento')>Departamento</option>
                                    <option value="casa" @selected(old('tipo_vivienda') === 'casa')>Casa</option>
                                    <option value="otro" @selected(old('tipo_vivienda') === 'otro')>Otro</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="checkbox">
                            <input type="checkbox" name="tiene_patio" value="1" @checked(old('tiene_patio'))>
                            ¿Tiene patio?
                        </label>
                    </div>

                    <div class="field">
                        <label class="checkbox">
                            <input type="checkbox" name="otras_mascotas" value="1" @checked(old('otras_mascotas'))>
                            ¿Tienes otras mascotas?
                        </label>
                    </div>

                    <div class="field">
                        <label class="label" for="miembros_familia">Miembros de la familia <span class="has-text-danger">*</span></label>
                        <div class="control">
                            <input class="input @error('miembros_familia') is-danger @enderror"
                                   type="number"
                                   id="miembros_familia"
                                   name="miembros_familia"
                                   value="{{ old('miembros_familia') }}"
                                   min="1"
                                   required>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="experiencia_con_mascotas">Experiencia con mascotas <span class="has-text-danger">*</span></label>
                        <div class="control">
                            <textarea class="textarea @error('experiencia_con_mascotas') is-danger @enderror"
                                      id="experiencia_con_mascotas"
                                      name="experiencia_con_mascotas"
                                      rows="4"
                                      placeholder="Cuéntanos sobre tu experiencia con mascotas..."
                                      required>{{ old('experiencia_con_mascotas') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <button type="submit" class="button is-primary">Enviar cuestionario</button>
                </div>
            </form>
        </div>
    </div>
@endsection
