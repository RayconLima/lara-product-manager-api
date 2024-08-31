<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();
        return UserResource::collection($users);
    }

    public function show(int $userId)
    {
        $user = $this->user($userId);
        return UserResource::make($user);
    }

    public function update(int $userId, UpdateUserRequest $request)
    {
        $user = $this->user($userId);
        $user->update($request->validated());
        return UserResource::make($user);   
    }

    public function destroy(int $userId)
    {
        $user = $this->user($userId);
        $user->delete();
        return response()->noContent(); 
    }

    private function user($userId)
    {
        $user = User::find($userId);
        if(!$user) {
            throw new NotFoundException('User not found');
        }

        return $user;
    }
}
