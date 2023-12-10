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

class CategoryController extends Controller
{
    // Créer une catégorie
    public function create(CategoryFormRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['name'] = $validatedData['category_name'];
        unset($validatedData['category_name']);

        Category::create($validatedData);
        return redirect()->route('admin.index')->with('success', "Catégorie '" . $validatedData['name'] . "' créée avec succès !");
    }

    // Supprimer une catégorie
    public function delete(Request $request)
    {
        $category = Category::find($request->id);
        $category->delete();
        return redirect()->back()->with('success', "Catégorie '" . $category->name . "' supprimée avec succès !");
    }
}
