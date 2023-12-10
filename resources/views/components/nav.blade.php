<nav class="left">
    <a href="/" class="logo"><h1>DEVPOST</h1></a>
    <div class="menu">
        @auth
            <a href="{{route('post.createShow')}}" class="btn">Créer un article</a>
            <hr>
        @endauth
        <div class="btn-list">
            Categories
            <div class="list">
                @if(!$categories->count())
                    Aucune catégorie
                @endif
                @foreach($categories as $category)
                    <a href="{{route('post.listByCategory', ['id'=> $category->id])}}"
                       class="item">{{$category->name}}</a>
                @endforeach
            </div>
        </div>
        <hr>
        <div class="btn-list">
            Tags
            <div class="list">
                @if(!$tags->count())
                    Aucun tag
                @endif
                @foreach($tags as $tag)
                    <a href="{{route('post.listByTag', ['id'=> $tag->id])}}" class="item">{{$tag->name}}</a>
                @endforeach
            </div>
        </div>
    </div>
</nav>
<div class="right">
    <nav class="top">
        <div class="container">
            <form action="{{route('post.listByTitle')}}" method="POST">
                @csrf
                @method('get')
                <input type="text" placeholder="Rechercher par titre" class="input" name="title">
            </form>
            <div class="top-right">
                @guest
                    <a href="{{route('auth.showLogin')}}" class="btn">Login</a>
                @endguest
                @auth
                    @if(auth()->user()->role_id == 2)
                        <a href="{{route('admin.index')}}" class="btn">admin</a>
                    @endif
                    <a href="{{route('auth.profile')}}" class="profilepic"></a>
                @endauth
            </div>
        </div>
    </nav>
    <div class="bottom">
        @if (session('success'))
            <div class="msg success">
                {{session('success')}}
            </div>
        @endif

        @if (session('danger'))
            <div class="msg danger">
                {{session('danger')}}
            </div>
        @endif
        @yield('content')
    </div>
</div>
