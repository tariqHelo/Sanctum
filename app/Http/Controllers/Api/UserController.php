<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\UserRequest;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::User();
             return response()->json([
                     'status_code'=>200, 
                     'message'=>'User login successfully'
                     ]);
                      
         } else {
             return response()->json([
                          'status_code'=>500, 
                          'message'=>'Unauthorised']);
         }
    }
    
    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'name' =>'required',
            'email' =>'required|email',
            'password' =>'required',
            // 'c_password' =>'required|same:password',
        ]); 

        if ($validator->fails()) {
            return response()->jason(['status_code'=>400, 'message'=>'Please validate error'] );
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return \response()->json([
            'status_code'=>200,
             'message'=>'User registered successfully'
        ]);
    }

}
