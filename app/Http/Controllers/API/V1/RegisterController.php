<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Resources\UserResource;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|min:6',
                'password' => 'required|min:8',
                'c_password' => 'required|same:password',
            ]);
    
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
    
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['access_token'] =  $user->createToken('api-token')->plainTextToken;
            $success['token_type'] =  'Bearer';
            $success['data'] = new UserResource($user);

            return $this->sendResponse($success, 'User register successfully.');

        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong.', $th->getMessage());       
        }
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), 
            [
                'email' => 'required|email|min:6',
                'password' => 'required|min:8',
            ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());  
            }

            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return $this->sendError('Model not found.');  
            }

            if (Auth::attempt($request->only('email', 'password'))) {
                $token = $user->createToken('api-token')->plainTextToken;
                $success = [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'data' => new UserResource($user), // Use a Resource to format the user data
                ];
                return $this->sendResponse($success, 'User login successfully.');
            } else {
                return $this->sendError('Invalid credentials.');  
            }

        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong.', $th->getMessage());       
        }
    }
    
}
