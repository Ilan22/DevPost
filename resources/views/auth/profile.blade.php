@extends('layout')

@section('title', "Profil - " . $user->name)

@section('content')
    <div class="profile margin-top">
        <div class="profile_container">
            <p>Role: {{$role->name}}</p>
            <form class="profile_form" action="{{route('auth.saveInfos')}}" method="POST">
                @method('PATCH')
                @csrf
                <div class="item">
                    <label for="name">Nom</label>
                    <input type="text" id="name" name="name" value="{{old('name', $user->name)}}"
                           class="input @error('name') inputerror @enderror" placeholder="Nom">
                    @error('name')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>

                <div class="item">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{old('email', $user->email)}}"
                           class="input @error('email') inputerror @enderror" placeholder="Mail">
                    @error('email')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>
                <button type="submit" class="btn">Sauvegarder</button>
            </form>
            <hr>
            <form class="profile_form" action="{{route('auth.savePassword')}}" method="POST">
                @method('PUT')
                @csrf
                <div class="item">
                    <label for="old_password">Ancien mot de passe</label>
                    <input type="password" id="old_password" name="old_password"
                           class="input @error('old_password') inputerror @enderror" placeholder="Ancien mot de passe">
                    @error('old_password')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>

                <div class="item">
                    <label for="password">Nouveau mot de passe</label>
                    <input type="password" id="password" name="password"
                           class="input @error('password') inputerror @enderror" placeholder="Nouveau mot de passe">
                    @error('password')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>

                <div class="item">
                    <label for="password_confirmation">Confirmer nouveau mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="input @error('password_confirmation') inputerror @enderror"
                           placeholder="Confirmer nouveau mot de passe">
                    @error('password_confirmation')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>
                <button type="submit" class="btn">Sauvegarder</button>
            </form>
        </div>
        @auth
            <form action="{{route('auth.logout')}}" class="logout_form" method="post">
                @csrf
                <button class="btn red">Se déconnecter</button>
            </form>
        @endauth
    </div>
@endsection
