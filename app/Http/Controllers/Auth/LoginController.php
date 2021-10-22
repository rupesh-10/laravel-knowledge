<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends ApiController
{
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];

        $response = $this->validateApiRequest($rules);
        if ($response !== true) {
            return $response;
        }
        $credentials = $request->only(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return $this->failResponse();
        }
        $user = $request->user();
        $token = $user->createToken('My  Token');

        return $this->successResponse([
            'user' => $user,
            'success' => true,
            'token' => $token->plainTextToken,
        ]);
    }

//   Logout
    public function logout(Request $request)
    {
        $accessToken = auth()->user()->token();
        $token = $request->user()->tokens->find($accessToken);
        $token->revoke();
        return $this->successResponse([
            'success' => true,
        ]);
    }

}
