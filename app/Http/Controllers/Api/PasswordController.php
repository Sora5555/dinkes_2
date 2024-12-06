<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    public function send_password_email(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);


        try{
            $status = Password::sendResetLink(
                $request->only('email')
            );

            $data = [
                'status' => 200,
                'data' => null,
            ];
        } catch (\Throwable $th){
            $data = [
                'status' => 500,
                'data' => null,
                'error' => $th->getMessage(),
            ]; 
        }

        return response()->json($data,$data['status']);	
    }
}
