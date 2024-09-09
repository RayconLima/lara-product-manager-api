<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\TokenInvalidException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\{User, PasswordResetToken};
use Hash;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function __construct(protected PasswordResetToken $passwordResetToken) {}
    public function __invoke(ResetPasswordRequest $request)
    {
        $input = $request->validated();
        $passwordReset = $this->passwordResetToken::query()
            ->with('user')
            ->whereDate('created_at', '>=', now()->subHours(24)->toDateString())
            ->whereToken($input['token'])
            ->first();
        
        if(!$passwordReset) {
            throw new TokenInvalidException('Password Reset Token Invalid.');
        }

        $user           = User::whereEmail($passwordReset->email)->first();
        $user->password = Hash::make($input['password']);
        $user->save();

        $this->passwordResetToken::where('email', $passwordReset->email)
        ->where('token', $input['token'])
        ->delete();

        return UserResource::make($user);
    }
}
