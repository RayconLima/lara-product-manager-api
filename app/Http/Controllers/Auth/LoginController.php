<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\SignInFormRequest;
use App\Exceptions\{LoginInvalidException, InternalServerException};

class LoginController extends Controller
{
    public function __invoke(SignInFormRequest $request)
    {
        $input = $request->validated();

        if (!auth()->attempt($input)) {
            throw new LoginInvalidException();
        }

        try {    
            session()->regenerate();
            $data = $this->authenticate($input['email'], $input['password']);
    
            return UserResource::make($data['user'])->additional($data['token']);
        } catch (Exception $e) {
            throw new InternalServerException();
        }
    }

    private function authenticate($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw new LoginInvalidException();
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => ['token' => $token],
        ];
    }
}
