@extends('layout')

@section('title', "Connexion")

@section('content')
    <form class="form margin-top" action="" method="POST">
        @csrf
        <div class="container">
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
        </div>
        <div class="buttons">
            <button type="submit" class="btn">Se connecter</button>
            <a href="{{route('auth.showRegister')}}" class="rightbtn">S'inscrire</a>
        </div>
    </form>
@endsection
