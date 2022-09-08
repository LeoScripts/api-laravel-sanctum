<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //registrar novo usuario

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string', // nome obrigatorio
            'email' => 'required|string|unique:users,email', // email obrigatorio e unico nao podera ser possivel criar um usuario como o mesmo email
            'password' => 'required|string|confirmed'
        ]);

        // criando usuario
        $user = User::create([
            // recebendo dados vindos do request
            'name' => $request->name,
            'email' => $request->email,
            // transformando a senha em uma Hash com o bcrypt
            'password' => bcrypt($request->password)
        ]);

        // creando o nosso token
        $token = $user->createToken('primeiroToken')->plainTextToken;

        // nosso respose de usuario e nosso token criado
        $response = [
            'user' => $user,
            'token' => $token
        ];

        // retornando ao cliente o respose e um codigo http
        return response($response, 201);
    }

    //login do usuario

    public function login(Request $request)
    {
        // recebendo email e senha
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // check o email do usuario pegando apenas o primeiro
        $user = User::where('email', $request->email)->first();

        // valida usuario e checka o password
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'email ou senha invalidos'
            ], 401);
        }

        // creando o nosso token
        $token = $user->createToken('primeiroToken')->plainTextToken;

        // nosso respose de usuario e nosso token criado
        $response = [
            'user' => $user,
            'token' => $token
        ];

        // retornando ao cliente o respose e um codigo http
        return response($response, 201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'logout efetuado com sucesso'
        ];
    }
}
