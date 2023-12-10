@extends('layout')

@section('title', "Admin")

@section('content')
    <div class="admin margin-top">

        <form class="form" action="{{route('category.create')}}" method="POST">
            @csrf
            <h2>Categories</h2>
            <div class="container">
                <div class="item">
                    <label for="category_name">Nom</label>
                    <input type="text" id="category_name" name="category_name" value="{{old('category_name')}}"
                           class="input @error('category_name') inputerror @enderror" placeholder="Nom">
                    @error('category_name')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>
                <button type="submit" class="btn">Créer</button>
            </div>
        </form>

        @if($categories->count())
            <form method="POST" action="{{ route('category.delete') }}">
                @csrf
                @method('delete')
                <select name="id" id="id" class="select">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <button class="btn red verif" type="submit">Supprimer</button>
            </form>
        @endif

        <hr>

        <form class="form" action="{{route('tag.create')}}" method="POST">
            @csrf
            <h2>Tags</h2>
            <div class="container">
                <div class="item">
                    <label for="tag_name">Nom</label>
                    <input type="text" id="tag_name" name="tag_name" value="{{old('tag_name')}}"
                           class="input @error('tag_name') inputerror @enderror" placeholder="Nom">
                    @error('tag_name')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>
                <button type="submit" class="btn">Créer</button>
            </div>
        </form>

        @if($tags->count())
            <form method="POST" action="{{ route('tag.delete') }}">
                @csrf
                @method('delete')
                <select name="id" id="id" class="select">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>

                <button class="btn red verif" type="submit">Supprimer</button>
            </form>
        @endif

        <hr>

        <div class="form users">
            <h2>Gérer les utilisateurs</h2>
            <form class="container" method="POST" action="{{route('admin.manageUser') }}">
                @csrf
                <select name="id" id="id" class="select">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} - {{$user->role->name}}</option>
                    @endforeach
                </select>

                <div class="btns">
                    <button class="btn" type="submit" name="action" value="setAdmin">Définir/Supprimer admin</button>
                    <button class="btn red verif" type="submit" name="action" value="delete">Supprimer</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const btns = document.querySelectorAll('.verif');

        btns.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const confirmation = 'Êtes-vous sûr ?';
                if (confirm(confirmation)) {
                    this.closest('form').submit();
                }
            });
        });
    </script>
@endsection
