@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
    <div class="columns is-centered">
        <div class="column is-half">
            <div class="box">
                <h2 class="title is-4 has-text-centered"><span class="icon"><i class="fas fa-user-plus"></i></span> Registrarse</h2>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="field">
                        <label class="label" for="name"><span class="icon is-small"><i class="fas fa-user"></i></span> Nombre</label>
                        <div class="control">
                            <input class="input @error('name') is-danger @enderror"
                                   type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="email"><span class="icon is-small"><i class="fas fa-envelope"></i></span> Correo electrónico</label>
                        <div class="control">
                            <input class="input @error('email') is-danger @enderror"
                                   type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="password"><span class="icon is-small"><i class="fas fa-lock"></i></span> Contraseña</label>
                        <div class="control">
                            <input class="input @error('password') is-danger @enderror"
                                   type="password"
                                   id="password"
                                   name="password"
                                   required>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="password_confirmation"><span class="icon is-small"><i class="fas fa-lock"></i></span> Confirmar contraseña</label>
                        <div class="control">
                            <input class="input"
                                   type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   required>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label"><span class="icon is-small"><i class="fas fa-user-tag"></i></span> Tipo de usuario</label>
                        <div class="control">
                            <div class="select is-fullwidth @error('role') is-danger @enderror">
                                <select name="role" required>
                                    <option value="">Selecciona un rol</option>
                                    <option value="adoptante" @selected(old('role') === 'adoptante')>Adoptante</option>
                                    <option value="refugio" @selected(old('role') === 'refugio')>Refugio</option>
                                </select>
                            </div>
                        </div>
                        @error('role')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field mt-4">
                        <div class="control">
                            <button type="submit" class="button is-primary is-fullwidth">
                                <span class="icon is-small"><i class="fas fa-user-plus"></i></span> Registrarse
                            </button>
                        </div>
                    </div>

                    <div class="has-text-centered mt-3">
                        <a href="{{ route('login') }}"><span class="icon is-small"><i class="fas fa-sign-in-alt"></i></span> ¿Ya tienes cuenta? Inicia sesión</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
