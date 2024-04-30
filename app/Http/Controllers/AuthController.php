<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            'status' => true,
            'message' => 'Voici touts les utilisateurs',
            'data' => $users
        ]);
    }

    public function unauthorize()
    {
        return response()->json([
            'message' => 'Non authentifié, Vous devrez être connecter pour effectuer cette action',   
        ]);
    }

    public function sendError($errorData, $message, $status = 500)
    {
        $response = [];
        $response['message'] = $message;
        if (!empty($errorData)) {
            $response['data'] = $errorData;
        }

        return response()->json($response, $status);
    }

    public function register(Request $request) 
    {
        $input = $request->only('name', 'email', 'password');

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            //'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors(), 'Validation Error', 422);
        }

        $input['password'] = Hash::make($input['password']); 
        $user = User::create($input); 
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data'          => $user,
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);

    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $ISSUE_ACCESS_TOKEN = 'issue-access-token';
        $ACCESS_API = 'access-api';

        $validator = Validator::make($input, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors(), 'Validation Error', 422);
        }
         
            // this authenticates the user details with the database and generates a token
            if (! Auth::attempt($input)) {
                return response()->json([
                    'message' => 'User not found'
                ], 401);
            }

            $user= Auth::user();

            if($user->blocked){
                return response()->json([
                    'message' => 'Votre compte a été bloqué'
                ], 401);
            }
            Auth::login($user);   

            $user   = User::where('email', $request->email)->firstOrFail();
            $token  = $user->createToken('auth_token')->plainTextToken;
            $accessToken = $user->createToken('access_token', [$ACCESS_API]);
            $refreshToken = $user->createToken('refresh_token', [$ISSUE_ACCESS_TOKEN]);

            return response()->json([
                'message'       => 'Connexion réussie',
                'access_token' => $accessToken->plainTextToken,
                'refresh_token' => $refreshToken->plainTextToken,
                'user' => auth()->user(),
                'token_type' => 'Bearer'
            ]);
           }

           public function refreshtoken(Request $request){
            $ACCESS_API = 'access-api';
            
            $accessToken = $request->usert()->createToken('access_token', [$ACCESS_API], Carbon::now()->addMinutes(config(' sanctum.expiration')));
                return ['token' => $accessToken->plainTextToken];
            }

            public function logout(){
                $user = User::find(Auth::user()->id);
                $user->tokens()->delete();
                return response()->json([
                    'message' => 'Deconnexion reussie'
                ]);
            }
}
