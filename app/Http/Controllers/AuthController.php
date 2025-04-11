<?php
namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller {
    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        // Valider les données de la requête
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Essayer de se connecter avec les informations fournies
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Obtenir l'utilisateur authentifié
            $user = Auth::user();

            // Générer le token pour cet utilisateur
            $token = $user->createToken('auth_token')->plainTextToken;

            // Retourner une réponse avec le message et le token
            return response()->json([
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                ]
            ]);
        }

        // Si l'authentification échoue, retourner une erreur
        return response()->json(['error' => 'Email ou mot de passe incorrect'], 401);
    }


    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,spectateur'
        ]);

        // Enregistrer l'utilisateur et récupérer son instance
        $user = $this->authService->register($request->all());
        if (!$user || !$user->id) {
            return response()->json(['message' => 'User creation failed'], 500);
        }
        // Générer le token pour cet utilisateur
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'user' => $user,
            'token' => $token
        ], 201);
    }
}
