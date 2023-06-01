<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email','password']);
        if(Auth::attempt($credentials) === false)
        {
            return response()->json(["message" => "Unauthorized"], 401);
        }
        $user = Auth::user();
        $user->tokens()->delete();
        //Por padrão os tokens são criados com habilidade coringa '*'
        //Caso o usuário não possa executar todas as operações você pode passar os nomes delas, ex: 'make:report'
        //Para validar uma habilidade $user->tokenCan('make:report')
        $token = $user->createToken('token', ['*']);
        return response()->json(["token" => $token->plainTextToken]);
    }
}
