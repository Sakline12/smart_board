<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' =>  'required|email|max:255|unique:users',
            'password' => 'required',
            'address' => 'required|string',
            'phone' => 'required',
            'designation_id' => 'required',
            'department_id' => 'required'
        );


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        $imageName = null;
        if ($image = $request->file('image')) {
            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile'), $imageName);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'designation_id' => $request->designation_id,
            'department_id' => $request->department_id,
            'image' => $imageName
        ]);

        $all_data = [
            'token' => $user->createToken('API TOKEN')->plainTextToken,
            'user name' => $user->first_name . " " . $user->last_name,
            'address' => $user->address,
            'phone' => $user->phone,
            'image' => $user->image,
            'designation' => $user->designation->title,
            'department' => $user->department->name,
        ];

        $data = [
            'status' => 201,
            'message' => "Registration Successful",
            'data' => $all_data
        ];
        return response()->json($data);
    }

    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            if ($user) {
                $data = [
                    'status' => true,
                    'message' => 'User Logged In Successfully',
                    'token' => $user->createToken('API TOKEN')->plainTextToken,
                    'status code' => 200,
                    'user name' => $user->first_name . " " . $user->last_name,
                    'designation' => $user->designation->title,
                    'department' => $user->department->name,
                ];

                return response()->json([$data]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(
            'Logout Successful'
        );
    }


    
}
