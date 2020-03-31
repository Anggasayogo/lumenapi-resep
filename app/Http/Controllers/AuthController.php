<?php

namespace App\Http\Controllers;
// panggil class request yangdimiliki iluminate http
use Illuminate\Http\Request;
// panggil facade has
use Illuminate\Support\Facades\Hash;
// panggil model user
use App\User;
// panggil class random
use \Illuminate\Support\Str;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));

        // insert data ke database menggunakan eloqouent
        $reqgister = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
         
        if($reqgister){
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Register!',
                'data' => $reqgister
            ],201);
        }else{
            return response()->json([
                'status' => flase,
                'message' => 'Gagal Register!',
                'data' => ''
            ],400);
        }

    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $users = User::where('email', $email)->first();
        if(Hash::check($password, $users->password)){
            $apitoken = base64_encode(Str::random(40));
            $users->update([
                'api_token' => $apitoken
            ]);

            return response()->json([
                'status' => true,
                'message' => 'You Are Loged-in !',
                'data' => [
                    'users' => $users,
                    'api_token' => $apitoken
                ]
            ],201);

        }else{
            return response()->json([
                'status' => false,
                'message' => 'Login Fail!',
                'data' => ''
            ],201);
        }
    }

}
