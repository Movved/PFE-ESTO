<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom'      => ['required', 'string', 'max:255'],
            'prenom'   => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:Utilisateur,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', 'in:ETUDIANT,ENSEIGNANT'],
        ]);
    
        $user = User::create([
            'nom'          => $request->nom,
            'prenom'       => $request->prenom,
            'email'        => $request->email,
            'mot_de_passe' => Hash::make($request->password),
            'role'         => $request->role,
            'actif'        => 1,
        ]);
    
        if ($request->role === 'ETUDIANT') {
            \DB::table('ETUDIANT')->insert([
                'cne'     => 'ETU-' . $user->id_user,
                'id_user' => $user->id_user,
            ]);
        }
    
        if ($request->role === 'ENSEIGNANT') {
            \DB::table('ENSEIGNANT')->insert([
                'specialite'     => 'Non définie',
                'is_chef'        => 0,
                'id_departement' => 1,
                'id_user'        => $user->id_user,
            ]);
        }
    
        return redirect()->route('login')->with('status', 'Compte créé avec succès ! Connectez-vous.');
    }
}