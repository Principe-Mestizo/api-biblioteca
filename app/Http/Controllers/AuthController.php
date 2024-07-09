<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ejecutar el procedimiento almacenado para autenticar al usuario
        $usuario = DB::select('CALL sp_LoginUsuario(?, ?)', [$request->email, $request->password]);

        if (empty($usuario)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        // Suponemos que el procedimiento devuelve solo un registro
        $user = $usuario[0];

        // Generar un token simple usando Str::random()
        $token = Str::random(64);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'tipo_usuario' => $user->tipo_usuario,
                'email' => $user->email
            ]
        ]);
    }
}
