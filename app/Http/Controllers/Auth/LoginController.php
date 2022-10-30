<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr, $request->remember)) {
            return $this->responseUnauthenticated('Credentials not match', 401);
        }

        $user = auth()->user();

        return $this->responseSuccess([
            'user' => UserResource::make($user)
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return $this->responseSuccess();
    }
}
