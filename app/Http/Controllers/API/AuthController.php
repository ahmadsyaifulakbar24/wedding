<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {

            // Mengecek credential login
            $credentials = request(['email', 'password']);
            if(!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            }

            // Jika Hash atau password tidak sesuai
            $user = User::where('email', $request->email)->first();
            if(!Hash::check($request->password, $user->password)) {
                throw new \Exception('Invalid Credentials');
            }

             // Jika berhasil maka loginkan
             $tokenResult = $user->createToken('authToken')->plainTextToken;
             return ResponseFormatter::success([
                 'access_token' => $tokenResult,
                 'token_type' => 'Bearer',
                 'user' => $user
             ], 'Authenticated');

        } catch (Exception $e) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 'Authentication failed', 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function fetch(Request $request)
    {
        return ResponseFormatter::success(
            $request->user(),
            'success get user profile',
        );
    }
}
