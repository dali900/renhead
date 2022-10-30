<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourcePaginated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    /**
     * Return user resource
     *
     * @param Request $requset
     * @return \Illuminate\Http\Response
     */
    public function getAuthUser(Request $requset)
    {
        $user = auth()->user();
        $userResource = null;
        if ($user) {
            $userResource = UserResource::make($user);
        }

        return $this->responseSuccess([
            'user' => $userResource
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        $perPage = $request->perPage ?? 20;
        $users = User::paginate($perPage);

        return $this->responseSuccess([
            'users' => UserResourcePaginated::make($users),
        ]);
    }

}
