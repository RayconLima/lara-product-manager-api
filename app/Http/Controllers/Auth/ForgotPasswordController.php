<?php

namespace App\Http\Controllers\Auth;

use App\Events\ForgotPasswordRequested;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Resources\PasswordResetResource;
use App\Http\Resources\UserResource;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function __invoke(ForgotPasswordRequest $request)
    {
        $input  = $request->validated();
        $user   = User::query()->whereEmail($input['email'])->first();
        
        if(!$user) {
            throw new NotFoundException();
        }

        $data = PasswordResetToken::create([
            'email' => $request->email,
            'token' => \Str::random(60),
        ]);
    

        // $data = $user->resetPasswordTokens()->create([
        //     'email' => $request->email,
        //     'token' => \Str::random(60),
        // ]);
        // $response = UserResource::make($user);
        // $response->token = $data->token;
        $response = [
            'user'  => UserResource::make($user),
            'token' => $data->token
        ];
        // dd(response()->json($response));

        ForgotPasswordRequested::dispatch($user, $data->token);
        return PasswordResetResource::make($response);
    }
}
