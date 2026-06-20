@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
    <div class="columns is-centered">
        <div class="column is-half">
            <div class="box">
                <h2 class="title is-4 has-text-centered">Iniciar sesión</h2>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="field">
                        <label class="label" for="email">Correo electrónico</label>
                        <div class="control">
                            <input class="input @error('email') is-danger @enderror"
                                   type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="password">Contraseña</label>
                        <div class="control">
                            <input class="input @error('password') is-danger @enderror"
                                   type="password"
                                   id="password"
                                   name="password"
                                   required>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" name="remember">
                                Recordarme
                            </label>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <button type="submit" class="button is-primary is-fullwidth">
                                Iniciar sesión
                            </button>
                        </div>
                    </div>

                    <div class="has-text-centered mt-3">
                        <a href="{{ route('register') }}">¿No tienes cuenta? Regístrate</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
