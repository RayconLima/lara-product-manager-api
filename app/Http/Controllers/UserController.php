<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Gate;
use Str;

class UserController extends Controller
{
    public function index()
    {
        // Gate::authorize('list_users', User::class);
        $users = User::paginate();
        return UserResource::collection($users);
    }
    
    public function show(int $userId)
    {
        $user = $this->user($userId);
        // Gate::authorize('show_user', $user);
        return UserResource::make($user);
    }
    
    public function store(StoreUserRequest $request)
    {
        $input  = $request->validated();

        if ($request->image) {
            $image              = $request->file('avatar');
            $originalFilename   = $image->getClientOriginalName();
            $extension          = $image->getClientOriginalExtension();
            $filename           = Str::slug($originalFilename, '-') . '-' . time() . '.' . $extension;
            $imagePath          = $image->storeAs('public/users', $filename);
            $input['avatar']     = $imagePath;
        }

        $user   = User::create($input);
        // Gate::authorize('update_user', $user);
        return UserResource::make($user);   
    }

    public function update(int $userId, UpdateUserRequest $request)
    {
        $user = $this->user($userId);
        // Gate::authorize('update_user', $user);
        $user->update($request->validated());
        return UserResource::make($user);   
    }
    
    public function destroy(int $userId)
    {
        $user = $this->user($userId);
        // Gate::authorize('destroy_user', $user);
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
