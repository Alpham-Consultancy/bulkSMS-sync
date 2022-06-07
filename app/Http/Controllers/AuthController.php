<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Mail;
Use Illuminate\Http\Response;
Use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
            'name' => 'required',
            
        ]);

    


        $user = User::create([
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'name' => $fields['name'],
            'role' => 'admin',
            
        ]);
        
        
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'message' => 'Account Created Succesfully',
            'user' => $user,
            'token' => $token,
            'status' => 'success',
        ];


        // Mail::to($fields['email'])->send(new WelcomeMail ($user));


        return response($response, 200);
        

        

    }


    public function show($id)
    {
        //
        $user = User::find($id);
          
        $response = [
            'message' => 'user details',
            'user' => $user
        ];

        return response($response, 200);
    }


    public function activate($id)
    {
        //
        $user = User::find($id);
        $user->status = 1 ;
        $user->update();
          
        $response = [
            'message' => 'User activated',
            'user' => $user
        ];

        return response($response, 200);
    }


    public function deactivate($id)
    {
        //
        $user = User::find($id);
        $user->status = 0 ;
        $user->update();
          
        $response = [
            'message' => 'User DeActivated',
            'user' => $user
        ];

        return response($response, 200);
    }



    


    public function resetPassword(Request $request)
    {
        //
        $fields = $request->validate([
            'email' => 'required|email',
        ]);

        // search for the email 
        $userCount = User::where('email', $request['email'])->count();
        $user = User::where('email', $request['email'])->first();
        
            if ($userCount > 0) {

                     //create a code to reset and send to user email 
                    $array = [1,2,3,4,5];
                    $randomNumber = Arr::random($array);

                    $random = Str::random(3);
                    $token = $random.$randomNumber;

                    $user = User::find($user['id']);
                    $user->passwordResetToken = $token;
                    $user->update();
                      //have email , code and new password to approve new password

                    // Mail::to($user['email'])->send(new ResetPasswordMail ($user));

                $response = [
                    'message' => 'user token sent to email',
                    'user' => $user
                ];
        
                return response($response, 200);
            } 
        


          
        $response = [
            'message' => 'User email not found',
        ];

        return response($response, 404);
    }





    public function changePassword(Request $request)
    {
        //
        $fields = $request->validate([
            'email' => 'required|email',
            'passwordResetToken' => 'required',
            'newPassword' => 'required',
        ]);

        // search for the email 
        $userCount = User::where('email', $request['email'])->count();
        $user = User::where('email', $request['email'])->first();
        
            if ($userCount > 0 &&  $user['passwordResetToken'] ==  $request['passwordResetToken'] ) {
                    $user = User::find($user['id']);
                    $user->password = Hash::make($request['newPassword']);
                    $user->update();

                $response = [
                    'message' => 'Password Changed Succesfully',
                    'user' => $user
                ];
        
                return response($response, 200);
            } 
        


          
        $response = [
            'message' => 'User email not found / passwordResetToken dont match',
        ];

        return response($response, 404);
    }





    





    public function allUsers(){
    
        $users = User::all();
          
        $response = [
            'message' => 'All Users',
            'Users' => $users
        ];

        return response($response, 200);
    }




    // Login
    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
            
        ]);

        // Check email 
        $user = User::where('email', $fields['email'])->first();
        // Check password 
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            # code...
            return response([
                'message' => 'Wrong Credentials'
            ], 401);
        }
        
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
            'message' => 'Welcome',
            'status' => 'success',
        ];

        return response($response, 200);
    }


    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged Out'
        ];
    }


    public function destroy($id)
    {
        //

        $user = User::find($id);
        $user->delete();

        $users = User::all();

        $response = [
            'message' => 'user Deleted Successfully ',
            'users' => $users,
        ];
        
        return response($response, 200);
    }
    

   

}
