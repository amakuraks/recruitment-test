<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessController extends Controller
{
    /**
     * Enable quick login to get bearer token
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'     => ['required', 'email'],
            'password'  => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user   = Auth::user();
            $token  = $user->createToken('access');

            return response()->json([
                'success'   => true,
                'message'   => 'API login success',
                'token'     => $token->plainTextToken,
            ], 200);
        }

        return response()->json([
            'success'    => false,
            'message'   => 'Invalid email or password provided',
        ], 403);
    }
}
