<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryFormRequest;
use App\Http\Requests\CommentFormRequest;
use App\Http\Requests\PostFormRequest;
use App\Http\Requests\TagFormRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    // Retourne la vue de création d'un article
    public function createShow(): View
    {
        return view('post.form', ['post'=>new Post()]);
    }

    // Créer un article
    public function create(PostFormRequest $request)
    {
        $user = Auth::user();
        $post = new Post($request->validated());
        $post = $user->posts()->save($post);
        $post->tags()->sync($request->validated('tags'));

        return redirect()->route('post.view', ['id'=>$post->id])->with('success', "Article '" . $post->title . "' créé avec succès !");
    }

    // Retourne la vue de modification d'un article
    public function editShow($id): View
    {
        $post = Post::find($id);
        if (!$post) return redirect('/post/list');
        return view('post.form', ['post'=>$post]);
    }

    // Modifie un article
    public function edit(PostFormRequest $request, $id)
    {
        $post = Post::find($id);
        $post->update($request->validated());
        $post->tags()->sync($request->validated('tags'));

        return redirect()->route('post.view', ['id'=>$id])->with('success', "Article '" . $post->title . "' modifié avec succès !");
    }

    // Retourne la vue de la liste des articles
    public function list(): View
    {
        $posts = Post::paginate(10);
        $user = Auth::user();
        return view('post.list', ['posts' => $posts, 'user'=>$user]);
    }

    // Retourne la vue de la liste des articles triés par titre
    public function listByTitle(Request $request): View
    {
        $posts = Post::where('title', 'LIKE', '%'.$request->title.'%')->paginate(10);
        $user = Auth::user();
        return view('post.list', ['posts' => $posts, 'user'=>$user]);
    }

    // Retourne la vue de la liste des articles triés par catégorie
    public function listByCategory($id): View
    {
        $posts = Post::where('category_id', $id)->paginate(10);
        $user = Auth::user();
        return view('post.list', ['posts' => $posts, 'user'=>$user]);
    }

    // Retourne la vue de la liste des articles triés par tag
    public function listByTag($id): View
    {
        $posts = Post::whereHas('tags', function ($query) use ($id) {
            $query->where('tags.id', $id);
        })->paginate(10);
        $user = Auth::user();
        return view('post.list', ['posts' => $posts, 'user'=>$user]);
    }

    // Retourne la vue de visualisation d'un article
    public function view($id)
    {
        $post = Post::find($id);
        if (!$post) return redirect('/post/list');
        $user = Auth::user();
        $hasLiked = false;
        if ($user) {
            $hasLiked = $user->postsLiked->contains($id);
        }
        return view('post.view', ['post' => $post, 'hasLiked' => $hasLiked, 'user'=>$user, 'isAdmin'=>$user->role_id === 2]);
    }

    // Gere la fonction "j'aime" ou bien le clic du bouton de modification de l'article
    public function action(Request $request, $id)
    {
        $user = Auth::user();
        if ($user) {
            if ($request->action === 'like') {
                $hasLiked = Auth::user()->postsLiked->contains($id);
                $post = Post::find($id);
                if ($hasLiked) {
                    $post->likes()->detach($user);
                } else {
                    $post->likes()->attach($user);
                }
                return redirect()->route('post.view', ['id' => $id]);
            } else {
                return redirect()->route('post.editShow', ['id'=>$id]);
            }
        }
        return redirect()->back()->with('danger', "Vous devez être connecté pour aimer un article !");
    }

    // Supprime un article
    public function delete($id){
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('post.list')->with('success', "Article '" . $post->title . "' supprimé avec succès");
    }
}
