<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        if (auth('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    // public function login(Request $request)
    // {
    //     try {
    //         $credentials = Validator::make($request->all(), [
    //             'password' => 'required|min:5',
    //             'email' => 'required|email|exists:' . Admin::class . ',email'
    //         ]);

    //         if ($credentials->fails()) {
    //             return response()->json([
    //                 'status' => 'serverside_error',
    //                 'msg' => 'Validation failed',
    //                 'errors' => $credentials->errors(),
    //             ], 422);
    //         }
    //         $admin = Admin::where('email', $request->email)->first();
    //         if (!$admin->hasRole('admin')) {
    //             return response()->json(['status' => 'error', 'message' => 'Login details are not valid']);
    //         }

    //         if (Auth::guard('admin')->attempt($credentials->validated())) {
    //             $user = Auth::guard('admin')->user();
    //             return response()->json(['status' => 'success', 'message' => 'Login Successfully']);
    //         }
    //         return response()->json(['status' => 'error', 'message' => 'Login details are not valid']);
    //     } catch (QueryException $e) {
    //         Log::error($e);
    //         return response()->json(['status' => 'error', 'msg' => 'Database error: ' . $e->getMessage()]);
    //     } catch (\Exception $e) {
    //         Log::error($e);
    //         return response()->json(['status' => 'error', 'msg' => 'Something Went Wrong: ' . $e->getMessage()]);
    //     }
    // }

    public function login(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:admins,email',
                'password' => 'required|min:5',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Attempt authentication with the admin guard
            if (Auth::guard('admin')->attempt($validator->validated())) {
                // Regenerate session to prevent session fixation
                $request->session()->regenerate();

                $user = Auth::guard('admin')->user();

                // Optionally check for specific roles if needed
                // if (!$user->hasAnyRole(['Super Admin', 'Admin', 'Listing'])) {
                //     Auth::guard('admin')->logout();
                //     return response()->json([
                //         'status' => 'error',
                //         'message' => 'Unauthorized: Invalid role',
                //     ], 403);
                // }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successful',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'roles' => $user->getRoleNames(),
                    ],
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password',
            ], 401);
        } catch (ValidationException $e) {
            // This should be caught by validator->fails(), but included for completeness
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        // $role = $user->getRoleNames()->first();
        $route = redirect()->route('admin.login.form');
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return $route;
    }
}
