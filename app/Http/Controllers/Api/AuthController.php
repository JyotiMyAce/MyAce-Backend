<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; // <-- Add this line
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseBuilder;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    public function register(Request $request)
    {
        // Validation rules
        $rules = [
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8',
            'phone'     => 'required', // Optional, remove if not needed
        ];

        // Custom validation messages
        $messages = [
            'firstname.required' => 'First name is required.',
            'lastname.required'  => 'Last name is required.',
            'email.required'     => 'Email is required.',
            'email.email'        => 'Email must be a valid email address.',
            'email.unique'       => 'This email is already registered.',
            'password.required'  => 'Password is required.',
            'password.min'       => 'Password must be at least 8 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return ResponseBuilder::error($validator->errors()->first(), 422);
        }

        // Combine firstname and lastname into name
        $name = $request->firstname . ' ' . $request->lastname;

        $user = User::create([
            'firstname'     => $request->firstname,
            'lastname'       => $request->lastname,
            'name'           => $name,
            'email'          => $request->email,
            'phone'          => $request->phone, // Optional, remove if not needed
            'password'       => Hash::make($request->password),
            'otp_verify'     => $request->otp_verify,
            'verify_uuid'    => $request->verify_uuid,
        ]);

        $token = $user->createToken('auth_token')->accessToken;

        $responseData = [
            'userData' => [
                'id'        => $user->id,
                'firstname' => $user->firstname,
                'lastname'  => $user->lastname,
                'name'      => $user->name,
                'email'     => $user->email,
                'phone'     => $user->phone,
            ],
            'token' => $token
        ];

        return ResponseBuilder::success($responseData, 'Signup successful', 201);
    }


   public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_type' => 'required|in:email,mobile',
            'email'      => 'required_if:login_type,email|email',
            'mobile'     => 'required_if:login_type,mobile',
            'password'   => 'required',
        ], [
            'login_type.required'   => 'Login type is required.',
            'login_type.in'         => 'Login type must be either email or mobile.',
            'email.required_if'     => 'Email is required when login type is email.',
            'email.email'           => 'Email must be valid.',
            'mobile.required_if'    => 'Mobile is required when login type is mobile.',
            'password.required'     => 'Password is required.',
        ]);

        if ($validator->fails()) {
            return ResponseBuilder::error($validator->errors()->first(), 422);
        }

        if ($request->login_type === 'email') {
            $user = User::where('email', $request->email)->first();
        } else {
            $user = User::where('phone', $request->mobile)->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ResponseBuilder::error('Invalid credentials.', 401);
        }

        $token = $user->createToken('auth_token')->accessToken;

        $responseData = [
            'userData' => [
                'id'        => $user->id,
                'firstname' => $user->firstname,
                'lastname'  => $user->lastname,
                'name'      => $user->name,
                'email'     => $user->email,
                'phone'     => $user->phone,
            ],
            'token' => $token
        ];

        return ResponseBuilder::success($responseData, 'Login successful', 200);
    }

    // User Logout
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
