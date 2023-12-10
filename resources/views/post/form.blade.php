@extends('layout')

@section('title', $post->id ? 'Modifier un article : ' . $post->title : 'Créer un article')

@section('content')
    <div class="create-post">
        <link rel="stylesheet" type="text/css" href="{{asset('trix/dist/trix.css')}}">
        <script type="text/javascript" src="{{asset('trix/dist/trix.umd.min.js')}}"></script>
        <form action="" method="POST">
            @csrf
            <div class="item">
                <input type="text" id="title" name="title" value="{{old('title', $post->title)}}"
                       class="input @error('title') inputerror @enderror" placeholder="Titre">
                @error('title')
                <div class="error">{{$message}}</div>
                @enderror
            </div>

            <div class="item">
                <input id="content" type="hidden" name="content" value="{{old('content', $post->content)}}">
                <trix-editor class="trix-editor @error('content') inputerror @enderror" input="content"></trix-editor>
                @error('content')
                <div class="error">{{$message}}</div>
                @enderror
            </div>

            <div class="details">
                <div class="item-select item">
                    <label for="tags[]">Tags :</label>
                    <select name="tags[]" id="tags[]" class="select" multiple>
                        @foreach($tags as $tag)
                            <option
                                @selected(in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray()))) value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    @error('tags')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>

                <div class="item-select item">
                    <label for="category_id">Categorie :</label>
                    <select name="category_id" id="category_id" class="select">
                        @foreach($categories as $category)
                            <option
                                @selected(old('category_id', $post->category_id) == $category->id) value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="btn-container">
                <button type="submit" class="btn create">
                    @if($post->id)
                        @method('patch')
                        Sauvegarder
                    @else
                        Créer
                    @endif
                </button>
            </div>
        </form>
    </div>
@endsection
