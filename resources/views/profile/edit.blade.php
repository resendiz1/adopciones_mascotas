@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')
    <h1 class="title"><span class="icon"><i class="fas fa-user"></i></span> Mi perfil</h1>

    <div class="columns mt-4">
        <div class="column is-one-third">
            <div class="box has-text-centered">
                <figure class="image is-128x128 mx-auto mb-3">
                    <img class="is-rounded" src="{{ $user->avatar_url }}" alt="Foto de perfil">
                </figure>

                @if ($user->avatar)
                    <form action="{{ route('profile.avatar.remove') }}" method="POST">
                        @csrf
                        <button class="button is-danger is-small is-outlined" type="submit"><span class="icon is-small"><i class="fas fa-trash-alt"></i></span> Eliminar foto</button>
                    </form>
                @endif
            </div>

            <div class="box">
                <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="field">
                        <label class="label"><span class="icon is-small"><i class="fas fa-camera"></i></span> Cambiar foto</label>
                        <div class="control">
                            <input class="input @error('avatar') is-danger @enderror" type="file" name="avatar" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" required>
                        </div>
                        @error('avatar')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field">
                        <div class="control">
                            <button class="button is-primary is-fullwidth" type="submit"><span class="icon is-small"><i class="fas fa-upload"></i></span> Subir foto</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="column">
            <div class="box">
                <h2 class="subtitle"><span class="icon is-small"><i class="fas fa-info-circle"></i></span> Información de la cuenta</h2>
                <p><strong><span class="icon is-small"><i class="fas fa-user"></i></span> Nombre:</strong> {{ $user->name }}</p>
                <p><strong><span class="icon is-small"><i class="fas fa-envelope"></i></span> Email:</strong> {{ $user->email }}</p>
                <p><strong><span class="icon is-small"><i class="fas fa-user-tag"></i></span> Rol:</strong>
                    @switch($user->role)
                        @case('admin') Administrador @break
                        @case('refugio') Refugio @break
                        @case('adoptante') Adoptante @break
                    @endswitch
                </p>
            </div>
        </div>
    </div>
@endsection
