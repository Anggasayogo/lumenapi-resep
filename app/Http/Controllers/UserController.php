<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function show($id)
    {
        $users = User::find($id);
        if($users){
            return response()->json([
                'status' => true,
                'message' => 'Detail users',
                'data' => $users
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'whent wrong users!',
                'data' => ''
            ],404);
        }
    }
}
