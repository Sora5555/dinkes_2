<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
			'email'	=> 'required',
			'password' => 'required'
		]);

		$user = User::where(['email' => $request->email])->first();

	    if (! $user) {
	        return response()->json([
	            'status' => 'error',
	            'message' => 'Akun Tidak Ditemukan'
	        ], 404);
	    }

	    if (!Hash::check($request->password, $user->password)) {
			// Helper::addLog("User Login Android", $user->id);
	        return response()->json([
	            'status' => 'error',
	            'message' => 'Email/Password Salah'
	        ], 404);
	    }

	    return response()->json([
	    	'status' => 'success',
	    	'data' => $user,
	    	'token' => $user->createToken('token')->plainTextToken
	    ], 200);	
    }

    public function logout(Request $request) 
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $respon = [
            'status' => 'success',
            'message' => 'Logout successfully',
            'errors' => null,
            'content' => null,
        ];
        return response()->json($respon, 200);
    }
}
