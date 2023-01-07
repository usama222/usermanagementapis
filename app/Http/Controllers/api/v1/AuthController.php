<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\AuthRequest;
use App\Http\Resources\v1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return response()->error('Unauthorized', 'Login credentials are invalid.', '1.0',  401);
        }
        $token = auth()->user()->createToken('mytoken')->plainTextToken;
        $user = new UserResource(auth()->user());
        return response()->tokenresponse($token, $user, '1.0');
    }
}
