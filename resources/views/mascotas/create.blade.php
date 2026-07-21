@extends('layouts.app')

@section('title', 'Registrar Mascota')

@section('content')
    <h1 class="title"><span class="icon"><i class="fas fa-plus-circle"></i></span> Registrar Mascota</h1>

    <div class="columns">
        <div class="column is-two-thirds">
            <form method="POST" action="{{ route('refugio.mascotas.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="box">
                    <h2 class="subtitle"><span class="icon is-small"><i class="fas fa-info-circle"></i></span> Información básica</h2>

                    <div class="field">
                        <label class="label" for="nombre">Nombre <span class="has-text-danger">*</span></label>
                        <div class="control">
                            <input class="input @error('nombre') is-danger @enderror" type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label" for="especie">Especie <span class="has-text-danger">*</span></label>
                                <div class="control">
                                    <div class="select is-fullwidth @error('especie') is-danger @enderror">
                                        <select id="especie" name="especie" required>
                                            <option value="">Selecciona</option>
                                            <option value="perro" @selected(old('especie') === 'perro')>Perro</option>
                                            <option value="gato" @selected(old('especie') === 'gato')>Gato</option>
                                            <option value="conejo" @selected(old('especie') === 'conejo')>Conejo</option>
                                            <option value="ave" @selected(old('especie') === 'ave')>Ave</option>
                                            <option value="otro" @selected(old('especie') === 'otro')>Otro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label" for="raza">Raza</label>
                                <div class="control">
                                    <input class="input" type="text" id="raza" name="raza" value="{{ old('raza') }}" placeholder="Opcional">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label" for="sexo">Sexo <span class="has-text-danger">*</span></label>
                                <div class="control">
                                    <div class="select is-fullwidth @error('sexo') is-danger @enderror">
                                        <select id="sexo" name="sexo" required>
                                            <option value="">Selecciona</option>
                                            <option value="macho" @selected(old('sexo') === 'macho')>Macho</option>
                                            <option value="hembra" @selected(old('sexo') === 'hembra')>Hembra</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label" for="tamano">Tamaño <span class="has-text-danger">*</span></label>
                                <div class="control">
                                    <div class="select is-fullwidth @error('tamano') is-danger @enderror">
                                        <select id="tamano" name="tamano" required>
                                            <option value="">Selecciona</option>
                                            <option value="pequeno" @selected(old('tamano') === 'pequeno')>Pequeño</option>
                                            <option value="mediano" @selected(old('tamano') === 'mediano')>Mediano</option>
                                            <option value="grande" @selected(old('tamano') === 'grande')>Grande</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label" for="edad_meses">Edad (meses)</label>
                                <div class="control">
                                    <input class="input" type="number" id="edad_meses" name="edad_meses" value="{{ old('edad_meses') }}" placeholder="Opcional" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label" for="peso">Peso (kg)</label>
                                <div class="control">
                                    <input class="input" type="number" step="0.01" id="peso" name="peso" value="{{ old('peso') }}" placeholder="Opcional" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <h2 class="subtitle"><span class="icon is-small"><i class="fas fa-file-alt"></i></span> Descripción y estado</h2>

                    <div class="field">
                        <label class="label" for="descripcion">Descripción <span class="has-text-danger">*</span></label>
                        <div class="control">
                            <textarea class="textarea @error('descripcion') is-danger @enderror" id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="status">Estado <span class="has-text-danger">*</span></label>
                        <div class="control">
                            <div class="select is-fullwidth @error('status') is-danger @enderror">
                                <select id="status" name="status" required>
                                    <option value="disponible" @selected(old('status', 'disponible') === 'disponible')>Disponible</option>
                                    <option value="pendiente" @selected(old('status') === 'pendiente')>Pendiente</option>
                                    <option value="adoptada" @selected(old('status') === 'adoptada')>Adoptada</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="checkbox">
                                    <input type="checkbox" name="esterilizado" value="1" @checked(old('esterilizado'))>
                                    Esterilizado
                                </label>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="checkbox">
                                    <input type="checkbox" name="desparasitado" value="1" @checked(old('desparasitado'))>
                                    Desparasitado
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <h2 class="subtitle"><span class="icon is-small"><i class="fas fa-camera"></i></span> Foto</h2>

                    <div class="field">
                        <div class="file is-boxed">
                            <label class="file-label">
                                <input class="file-input" type="file" name="foto" accept="image/*">
                                <span class="file-cta">
                                    <span class="file-label">Seleccionar foto</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-primary"><span class="icon is-small"><i class="fas fa-save"></i></span> Guardar mascota</button>
                        <a href="{{ route('refugio.mascotas.index') }}" class="button is-light"><span class="icon is-small"><i class="fas fa-times"></i></span> Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
