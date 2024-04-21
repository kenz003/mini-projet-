<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Eleve;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'grade' => 'required|string',
            'email' => 'required|email|unique:users',  
            'phone' => 'required|string',
            'password' => 'required|min:6|confirmed', 
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        // Créer un User
        $user = User::create($validatedData);

        // Créer un Eleve
        $eleve = Eleve::create([
            'name' => $validatedData['name'],
            'grade' => $validatedData['grade'],
            'phone' => $validatedData['phone'],
            'user_id' => $user->id, // Lier l'Eleve à l'utilisateur
            
        ]);
        

        // Générer un token pour le nouvel utilisateur
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'user' => $user, // Assurez-vous de renvoyer le bon objet
            'eleve' => $eleve,
            'token' => $token,
        ], 201);  
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $credentials['email'])->first(); // Utilisez le bon modèle
    
        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
    
            return response()->json([
                'user' => $user, // Assurez-vous de renvoyer le bon objet
                'token' => $token,
                'message' => 'Connexion réussie',
            ], 200);
        } else {
            return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
        }
    }
    
    public function logout(Request $request)
    {
        $user = Auth::user();  // Récupérer l'utilisateur connecté
        
        // Révoquer tous les tokens associés à l'utilisateur
        $user->tokens()->delete(); 

        return response()->json(['message' => 'Déconnexion réussie'], 200);  // Statut de succès
    }
}