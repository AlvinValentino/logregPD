<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller {
    public function __invoke(Request $request) {
        Validator::make($request->all(), [
            'email' => 'required|email|unique:logreg',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');

        if(!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'message' => 'Login Gagal!'
            ]);
        }

        return response()->json([
            'message' => 'Login Berhasil!',
            'token' => $token,
            'data' => auth()->user(),
        ]);
    }
}