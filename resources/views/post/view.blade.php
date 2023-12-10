@extends('layout')

@section('title', $post->title)

@section('content')
    <div class="view-post">
        <div class="title">
            {{$post->title}}
        </div>
        <div class="post-infos-container">
            <div class="content">
                {!!$post->content!!}
            </div>
            <div class="right">
                <div class="infos">
                    <div class="name">
                        {{$post->user->name}}
                    </div>
                    <div class="date">
                        {{$post->created_at->format('d/m/Y')}}
                    </div>
                    <div class="chips">
                        <div class="chip">
                            {{$post->category->name}}
                        </div>
                        <div class="tags">
                            @foreach($post->tags as $tag)
                                <div class="chip tag">
                                    {{$tag->name}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="toolbar">
                    <form action="{{route('post.action', ['id'=>$post->id])}}" method="post" class="action">
                        @csrf
                        <div class="like">
                            <button type="submit" name="action" value="like" class="{{$hasLiked ? 'liked' : ''}}">
                                <x-fas-heart/>
                            </button>
                            {{$post->likes->count()}}
                        </div>
                        @auth
                            @if($user->id === $post->user->id || $isAdmin)
                                <button type="submit" name="action" value="edit">
                                    <x-uiw-edit/>
                                </button>
                            @endif
                        @endauth
                    </form>
                </div>
                @if($user->id === $post->user->id || $isAdmin)
                    <form action="" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="delete btn red" data-confirm="Êtes-vous sûr de vouloir supprimer cet article ?">
                            Supprimer
                        </button>
                        <script>
                            const deleteButtons = document.querySelectorAll('.delete');

                            deleteButtons.forEach(button => {
                                button.addEventListener('click', function (e) {
                                    e.preventDefault();
                                    const confirmation = this.getAttribute('data-confirm');
                                    if (confirm(confirmation)) {
                                        this.closest('form').submit();
                                    }
                                });
                            });
                        </script>
                    </form>
                @endif
            </div>
        </div>
        <div class="comments">
            {{$post->comments->count()}} commentaire(s)
            <form class="new-comment" action="{{route('comment.addComment', ['id'=>$post->id])}}" method="POST">
                @csrf
                <textarea oninput="auto_grow(this)" name="content"
                          class="@error('content') inputerror @enderror" placeholder="Écrivez votre commentaire ici"></textarea>
                @error('content')
                <div class="error">{{$message}}</div>
                @enderror
                <button type="submit" class="btn">Ajouter un commentaire</button>
                <script>
                    function auto_grow(element) {
                        element.style.height = "5px";
                        element.style.height = (element.scrollHeight) + "px";
                    }
                </script>
            </form>

            @foreach($post->comments as $comment)
                <div class="comment">
                    <div class="content">
                        <div class="infos">
                            <div class="name">
                                {{$comment->user->name}}
                            </div>
                            <div class="date">
                                {{$comment->created_at->format('d/m/Y')}}
                            </div>
                            @if($user->id === $comment->user->id || $isAdmin)
                                <form
                                    action="{{route('comment.deleteComment', ['id'=>$post->id, 'comment_id'=>$comment->id])}}"
                                    method="post" class="btns">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" name="action" value="delete">
                                        supprimer
                                    </button>
                                </form>
                            @endif
                        </div>
                        {!! nl2br(e($comment->content)) !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
