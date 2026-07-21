@extends('layouts.app')

@section('title', 'Elegir tipo de cuenta')

@section('content')
    <div class="columns is-centered">
        <div class="column is-half">
            <div class="box">
                <h2 class="title is-4 has-text-centered"><span class="icon"><i class="fas fa-paw"></i></span> Bienvenido a Adopciones Mascotas</h2>
                <p class="has-text-centered mb-4">Elige el tipo de cuenta que deseas crear:</p>

                <form method="POST" action="{{ route('auth.google.register') }}">
                    @csrf

                    <div class="field">
                        <div class="control">
                            <label class="radio is-block mb-3 p-3" style="border: 1px solid #dbdbdb; border-radius: 4px;">
                                <input type="radio" name="role" value="adoptante" required>
                                <strong>Adoptante</strong>
                                <p class="has-text-grey is-size-7 mt-1">Quiero adoptar una mascota</p>
                            </label>
                            <label class="radio is-block p-3" style="border: 1px solid #dbdbdb; border-radius: 4px;">
                                <input type="radio" name="role" value="refugio" required>
                                <strong>Refugio</strong>
                                <p class="has-text-grey is-size-7 mt-1">Represento a un refugio o asociación</p>
                            </label>
                        </div>
                        @error('role')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field mt-4">
                        <div class="control">
                            <button type="submit" class="button is-primary is-fullwidth">
                                <span class="icon is-small"><i class="fas fa-arrow-right"></i></span> Continuar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
