<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request as HttpRequest;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param Request $request
     * @return Response
     */
    public function register(HttpRequest $request)
    {
        // Validate incoming request
        $this->validate($request, [
            'name'      => 'required|string',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|confirmed'
        ]);

        try {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            // return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);
        } catch (\Throwable $th) {
            //return error message
            return response()->json(['message' => 'User Registration Failed'], 400);
        }
    }
}
