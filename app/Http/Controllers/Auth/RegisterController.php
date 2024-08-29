<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpFormRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class RegisterController extends Controller
{
    public function __invoke(SignUpFormRequest $request)
    {
        $input  =   $request->validated();
        $user   =   User::create($input);
        return UserResource::make($user);
    }
}
