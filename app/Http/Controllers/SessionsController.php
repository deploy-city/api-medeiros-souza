<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class SessionsController extends Controller
{
    use AuthenticatesUsers;

    public function store(Request $request)
    {
        try {
            $this->validateLogin($request);
            $credentials = $this->credentials($request);

            $user = User::where('email', $request->email)->first();

            $token = \JWTAuth::attempt($credentials);

            return response(json_encode([
                "token" => $token, "user" => $user
            ]), 201);

        } catch (\Exception $exception) {
            return response(json_encode(['error' => $exception->getMessage()]));
        }
    }

    public function update()
    {
        $token = auth()->refresh();
        return response(json_encode(['token' => $token]), 201);
    }
}
