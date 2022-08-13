<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $this->validate($request, [
            'name' => ['required', 'min:2'],
            'username' => ['required', 'min:3'],
            'email' => ['required', 'email', 'unique:logreg'],
            'password' => ['required', 'min:6'],
        ]);

        $data['password'] = bcrypt($data['password']);

        if(preg_match("/@/", $data['username']) && !preg_match("/@$/", $data['username'])) {
            if(User::where('email', $data['email'])->exists()) {
                return back()->with('regError', 'Email sudah terpakai!');
            } else {
                User::create($data);
                return response()->json([
                    'msg'=>"success membuat user"
                ]);
            }
        }
    }
}
