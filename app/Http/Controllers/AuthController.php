<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function auth(Request $request): string
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);
     
        $user = User::where('email', $request->email)->first();
     
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
     
        return $user->createToken($request->device_name)->plainTextToken;
    }
    public function register(AuthRequest $request): JsonResponse
    {     
        try {
            $user = User::create([
                'name'  => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role ?? 'user'
            ]);
    
            return response()->json(['success' => 'Usuário criado com sucesso'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Não foi possível criar o usuário.'], $e->getMessage());
        }
    }
    
    public function logout(Request $request): JsonResponse
    {
        $request->user->tokens()->delete();

        return response()->json([
           'message' => 'Sessão encerrada com sucesso!'
        ], 200);

    }
}
