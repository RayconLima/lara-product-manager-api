<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpFormRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class RegisterController extends Controller
{
    public function __invoke(SignUpFormRequest $request)
    {
        $input          =   $request->validated();
        $input['token'] = \Str::uuid();
        $user           =   User::create($input);
        event(new UserRegistered($user));

        return response()->json(UserResource::make($user), 201);
    }
}
