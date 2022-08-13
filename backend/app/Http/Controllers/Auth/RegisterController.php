<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller {
    public function __invoke(Request $request) {
        $data = Validator::make($request->all(), [
            'username' => 'required|min:3',
            'name' => 'required|min:3',
            'email' => 'required|email|unique:logreg',
            'password' => 'required|min:6',
        ]);

        $data['password'] = bcrypt($data['password']);

        if(preg_match("/@/", $data['username']) && !preg_match("/@$/", $data['username'])) {
            if(User::where('email', $data['email'])->exists()) {
                return response()->json([
                    'message' => 'Registrasi Gagal!'
                ]);
            }

            User::create($data);
            return response()->json([
                'message' => 'Registrasi Berhasil!',
            ]);
        }
    }
}