@extends('layout')

@section('title', "DevPost")

@section('content')
    <div class="list-post">
        @if($posts->isEmpty())
            <div class="empty">
                No posts found
            </div>
        @endif
        @foreach($posts as $post)
            <div class="post-container">
                <a href="{{route('post.view', $post->id)}}">
                    <div class="card-container">
                        <div class="post">
                            <div class="post-left">
                                <div class="title">
                                    {{$post->title}}
                                </div>
                                <div class="author">
                                    {{$post->user->name}}
                                </div>
                                <div class="date">
                                    {{$post->created_at->format('d/m/Y')}}
                                </div>
                            </div>
                            <div class="post-right">

                                <x-maki-arrow/>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="card-bottom">
                    <div class="chips">
                        <div class="chip">
                            {{$post->category->name}}
                        </div>
                        @foreach($post->tags as $tag)
                            <div class="chip tag">
                                {{$tag->name}}
                            </div>
                        @endforeach
                    </div>
                    <div class="icons">
                        <div class="icon {{$user->postsLiked->contains($post->id) ? 'liked' : ''}}">
                            <x-fas-heart/>
                        </div>
                        {{$post->likes->count()}}
                        -
                        <div class="icon">
                            <x-bxs-comment-detail/>
                        </div>
                        {{$post->comments->count()}}
                    </div>
                </div>
            </div>
        @endforeach
            <div class="pagination-container">
                {{ $posts->links('post.pagination') }}
            </div>
    </div>
@endsection
