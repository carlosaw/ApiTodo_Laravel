<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
  public function create(Request $request) {
    $array = ['error' => ''];

    // Validando
    $rules = [
      'email' => 'required|email|unique:users,email',
      'password' => 'required'
    ];

    $validator = Validator::make($request->all(), $rules);

    if($validator->fails()) {
      $array['error'] = $validator->messages();
      return $array;
    }
    // Pegando os dados
    $email = $request->input('email');
    $password = $request->input('password');

    // Criando novo Usuário
    $newUser = new User();
    $newUser->email = $email;
    $newUser->password = password_hash($password, PASSWORD_DEFAULT);
    $newUser->token = '';
    $newUser->save();

    // Logar o usuário recém criado.

    return $array;
  }

  public function login(Request $request) {
    $array = ['error' => ''];

    $creds = $request->only('email', 'password');

    if(Auth::attempt($creds)) {
        $user = User::where('email', $creds['email'])->first();

        $item = time().rand(0,9999);
        $token = $user->createToken($item)->plainTextToken;

        $array['token'] = $token;
    } else {
      $array['error'] = 'E-mail e/ou senha incorretos!';
    }

    return $array;
  }

  public function logout(Request $request) {
    $array = ['error' => ''];

    $user = $request->user();
    //$array['email'] = $user->email;//  Usuário que está logado!
    $user->tokens()->delete();// Deleta todos os tokens do usuário.
    
    return $array;
  }
}