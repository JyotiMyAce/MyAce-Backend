<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; // <-- Add this line
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseBuilder;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;


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
            'phone'     => 'required|unique:users', // Optional, remove if not needed
        ];

        // Custom validation messages
        $messages = [
            'firstname.required' => 'First name is required.',
            'lastname.required'  => 'Last name is required.',
            'email.required'     => 'Email is required.',
            'email.email'        => 'Email must be a valid email address.',
            'email.unique'       => 'This email is already registered.',
            'phone.unique'       => 'This phone is already registered.',
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
            'login_type'   => 'required|in:email,phone,google',
            'email'        => 'required_if:login_type,email,google|email',
            'phone'        => 'required_if:login_type,phone',
            'password'     => 'required_if:login_type,email,phone',
            'google_id'    => 'required_if:login_type,google',
            'name'         => 'required_if:login_type,google',
            // Add other fields as needed (e.g., avatar)
        ], [
            'login_type.required'   => 'Login type is required.',
            'login_type.in'         => 'Login type must be email, phone, or google.',
            'email.required_if'     => 'Email is required when login type is email or google.',
            'email.email'           => 'Email must be valid.',
            'phone.required_if'     => 'Phone is required when login type is phone.',
            'password.required_if'  => 'Password is required for email or phone login.',
            'google_id.required_if' => 'Google ID is required for Google login.',
            'name.required_if'      => 'Name is required for Google login.',
        ]);

        if ($validator->fails()) {
            return ResponseBuilder::error($validator->errors()->first(), 422);
        }

        if ($request->login_type === 'google') {
            $user = User::where('google_id', $request->google_id)
                        ->orWhere('email', $request->email)
                        ->first();

            if (!$user) {
                $user = User::create([
                    'name'      => $request->name,
                    'email'     => $request->email,
                    'google_id' => $request->google_id,
                    'password'  => bcrypt(Str::random(16)), 
                ]);
            } else if (!$user->google_id) {
                $user->google_id = $request->google_id;
                $user->save();
            }

            $token = $user->createToken('auth_token')->accessToken;

        } else {
            // Email or phone login
            if ($request->login_type === 'email') {
                $user = User::where('email', $request->email)->first();
            } else {
                $user = User::where('phone', $request->phone)->first();
            }

            if (!$user || !Hash::check($request->password, $user->password)) {
                return ResponseBuilder::error('Invalid credentials.', 401);
            }

            $token = $user->createToken('auth_token')->accessToken;
        }

        $responseData = [
            'userData' => [
                'id'        => $user->id,
                'firstname' => $user->firstname ?? '',
                'lastname'  => $user->lastname ?? '',
                'name'      => $user->name,
                'email'     => $user->email,
                'phone'     => $user->phone,
                // Add other fields as needed
            ],
            'token' => $token
        ];

        return ResponseBuilder::success($responseData, 'Login successful', 200);
    }

    public function getuser($id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) {
            return ResponseBuilder::error('User not found', 404);
        }

        $responseData = ['user' => $user];

        return ResponseBuilder::success($responseData, 'Data fetch successful', 200);
    }

    public function forgotPasswordByPhone(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
        ], [
            'phone.required'        => 'Phone is required.',
        ]);

        if ($validator->fails()) {
            return ResponseBuilder::error($validator->errors()->first(), 422);
        }

        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            return ResponseBuilder::error('User not found', 404);
        }

        $user->password = Hash::make($request->newpassword);
        $user->save();

         $responseData = [
            'userData' => [
                'id'        => $user->id,
                'name'      => $user->name,
                'phone'     => $user->phone,
            ]
        ];
        return ResponseBuilder::success($responseData, 'Password reset successful.', 200);
    }


    // User Logout
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
