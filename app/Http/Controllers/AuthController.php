<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): string
    {
        // Autenticação email e senha
        $credentials = $request->all(['email', 'password']);
        $token = auth('api')->attempt($credentials);

        if ($token) {
            return response()->json(['token' => $token]);
        }

        return response()->json(['erro' => 'Usuário ou senha inválido!'], 403);
    }

    public function logout(): string
    {
        auth('api')->logout();
        return response()->json(['message' => 'Logout success']);
    }

    public function refresh(): string
    {
        $token = auth('api')->refresh();
        return response()->json(['token' => $token]);
    }

    public function me(): string
    {
        return response()->json(auth()->user());
    }

    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
//            'token_type' => 'bearer',
//            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
