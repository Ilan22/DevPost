@extends('layout')

@section('title', "Inscription")

@section('content')
    <form class="form margin-top" action="" method="POST">
        @csrf
        <div class="container">
            <div class="item">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" value="{{old('name')}}"
                       class="input @error('name') inputerror @enderror" placeholder="Nom">
                @error('name')
                <div class="error">{{$message}}</div>
                @enderror
            </div>
            <div class="item">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{old('email')}}"
                       class="input @error('email') inputerror @enderror" placeholder="Email">
                @error('email')
                <div class="error">{{$message}}</div>
                @enderror
            </div>

            <div class="item">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password"
                       class="input @error('password') inputerror @enderror" placeholder="Mot de passe">
                @error('password')
                <div class="error">{{$message}}</div>
                @enderror
            </div>

            <div class="item">
                <label for="password_confirmation">Confirmer mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="input @error('password_confirmation') inputerror @enderror" placeholder="Confirmer mot de passe">
                @error('password_confirmation')
                <div class="error">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="buttons">
            <button type="submit" class="btn">S'inscrire</button>
            <a href="{{route('auth.showLogin')}}" class="rightbtn">Se connecter</a>
        </div>
    </form>
@endsection
