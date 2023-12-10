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

class CommentController extends Controller
{
    // Créer un commentaire
    public function addComment(CommentFormRequest $request, $id)
    {
        $comment = new Comment($request->validated());
        $comment->post()->associate(Post::find($id));
        $comment->user()->associate(Auth::user());
        $comment->save();
        return redirect()->back()->with('success', "Commentaire ajouté avec succès");
    }

    // Supprimer un commentaire
    public function deleteComment($id, $comment_id)
    {
        Comment::find($comment_id)->delete();
        return redirect()->back()->with('success', "Commentaire supprimé avec succès");
    }
}
