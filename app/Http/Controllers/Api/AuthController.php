<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!Auth::attempt($loginData)) {
            return response()->error('error', 'Invalid Credentials');
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $access_token_array['access_token']=$accessToken;
        $user_auth=array_merge(auth()->user()->toArray(),$access_token_array);
        return response()->success('User Authenticated',$user_auth);
    }
    public function register(Request $request)
    {
        try
        {
        //validating incomming request for customer
        $validatedData=Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validatedData->fails()) {
            return response()->error($validatedData->errors()->first(),$validatedData->errors()->getMessageBag());
         }
        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        }
        catch(Exception $e)
        {
        return response()->error('error',$e->getmessage());
        }
        return response()->success('Successfully Registered',$user);
    }
    
}
