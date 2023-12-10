<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryFormRequest;
use App\Http\Requests\TagFormRequest;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TagController extends Controller
{
    // Créer un tag
    public function create(TagFormRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['name'] = $validatedData['tag_name'];
        unset($validatedData['tag_name']);

        Tag::create($validatedData);
        return redirect()->route('admin.index')->with('success', "Tag '" . $validatedData['name'] . "' créé avec succès !");
    }

    // Supprimer un tag
    public function delete(Request $request)
    {
        $tag = Tag::find($request->id);
        $tag->delete();
        return redirect()->back()->with('success', "Tag '" . $tag->name . "' supprimé avec succès !");
    }
}
