<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    // Retourne la vue de la page admin
    public function index(): View
    {
        $users = User::all();
        return view('admin.index', ['users' => $users]);
    }

    // Gere la suppression ou changement de role d'un utilisateur
    public function manageUser(Request $request)
    {
        $user = User::find($request->id);
        if ($user->id !== Auth::user()->id) {
            if ($request->action === 'setAdmin') {
                $user->role_id = $user->role_id === 1 ? 2 : 1;
                $user->save();
                return redirect()->back()->with('success', 'Le rôle de ' . $user->name . ' a été modifié avec succès !');
            } else {
                $user->delete();
                return redirect()->back()->with('success', "Suppression réussie de l'utilisateur " . $user->name . " !");
            }
        } else {
            return redirect()->back()->with('danger', "Vous ne pouvez pas effectuer cette action sur vous-même !");
        }
    }
}
