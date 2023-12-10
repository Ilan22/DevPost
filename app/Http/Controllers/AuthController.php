<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterFormRequest;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\SaveinfosFormRequest;
use App\Http\Requests\SavePasswordFormRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    // Retourne la vue d'inscription
    public function showRegister(): View
    {
        return view('auth.register');
    }

    // Créer un utilisateur
    public function register(RegisterFormRequest $request)
    {
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        return redirect()->route('auth.login')->with('success', "Inscription réussie !");
    }

    // Retourne la vue de connexion
    public function showLogin(): View
    {
        return view('auth.login');
    }

    // Connecte l'utilsateur
    public function login(LoginFormRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();
            return redirect()->route('post.list')->with('success', "Connexion réussie !");
        }

        return back()->onlyInput('email')->with('danger', "Identifiants incorrects.");
    }

    // Déconnecte l'utilisateur
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerate();
        return redirect()->route('auth.login')->with('success', "Déconnexion réussie !");
    }

    // Retourne la vue du profil
    public function profile(): View
    {
        $user = auth()->user();
        $role = Role::findOrFail($user->role_id);
        return view('auth.profile', ['user' => $user, 'role' => $role]);
    }

    // Sauvegarde les infos d'un utilisateur
    public function saveInfos(SaveinfosFormRequest $request)
    {
        $user = User::findOrFail(\auth()->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $request->session()->regenerate();

        return redirect()->route('auth.profile')->with('success', "Informations enregistrées avec succès !");
    }

    // Sauvegarde le nouveau mot de passe d'un utilisateur
    public function savePassword(SavePasswordFormRequest $request)
    {
        $user = User::findOrFail(\auth()->user()->id);
        $type = "success";
        $message = "Successfully saved password !";
        if (Hash::check($request->old_password, $user->password)){
            $user->password = Hash::make($request->password);
            $user->save();
        } else{
            $type = "danger";
            $message = "Old password doesn't match";
        }

        return redirect()->route('auth.profile')->with($type, $message);
    }
}
