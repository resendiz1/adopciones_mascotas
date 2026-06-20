@extends('layouts.app')

@section('title', 'Editar Perfil del Refugio')

@section('content')
    <h1 class="title">Editar Perfil del Refugio</h1>

    <div class="columns">
        <div class="column is-two-thirds">
            <form method="POST" action="{{ route('refugio.shelter.update') }}">
                @csrf
                @method('PUT')

                <div class="box">
                    <div class="field">
                        <label class="label" for="name">Nombre del refugio <span class="has-text-danger">*</span></label>
                        <div class="control">
                            <input class="input @error('name') is-danger @enderror"
                                   type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $shelter->name) }}"
                                   required>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="description">Descripción</label>
                        <div class="control">
                            <textarea class="textarea @error('description') is-danger @enderror"
                                      id="description"
                                      name="description"
                                      rows="4">{{ old('description', $shelter->description) }}</textarea>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="address">Dirección</label>
                        <div class="control">
                            <input class="input @error('address') is-danger @enderror"
                                   type="text"
                                   id="address"
                                   name="address"
                                   value="{{ old('address', $shelter->address) }}">
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label" for="ciudad">Ciudad</label>
                                <div class="control">
                                    <input class="input @error('ciudad') is-danger @enderror"
                                           type="text"
                                           id="ciudad"
                                           name="ciudad"
                                           value="{{ old('ciudad', $shelter->ciudad) }}">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label" for="estado">Estado</label>
                                <div class="control">
                                    <input class="input @error('estado') is-danger @enderror"
                                           type="text"
                                           id="estado"
                                           name="estado"
                                           value="{{ old('estado', $shelter->estado) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="phone">Teléfono</label>
                        <div class="control">
                            <input class="input @error('phone') is-danger @enderror"
                                   type="text"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone', $shelter->phone) }}">
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-primary">Guardar cambios</button>
                        <a href="{{ route('dashboard.refugio') }}" class="button is-light">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
