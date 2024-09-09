<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;

class MeController extends Controller
{
    public function __invoke()
    {
        $user = User::whereId(auth()->id())->first();
        $user->loadMissing('roles');
        return UserResource::make($user);
    }
}
