<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserAuthController extends Controller
{
    public function login(Request $request)
    {
        return view('auth/login');
    }

    public function loginApi(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response([
                'success' => FALSE,
                'message' => 'Failed to login',
            ]);
        }

        $token = auth()->user()->createToken('API Token')->plainTextToken;

        return response([
            'success' => TRUE,
            'message' => 'Organizations list',
            'data' => $token,
        ]);

    }
}
