<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Handle user login request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:4|max:20',
            'password' => 'required|string|min:4|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'msgField' => $validator->errors()
            ]);
        }

        // Get user by username
        $user = User::where('username', $request->username)
                    ->where('user_visible', true)
                    ->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->password, $user->user_password)) {
            return response()->json([
                'status' => false,
                'message' => 'Username atau password tidak valid',
            ]);
        }

        // Log the user in
        Auth::login($user, $request->has('remember'));

        // Determine redirect based on role
        $redirect = $this->getRedirectRouteByRole($user);

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'redirect' => $redirect
        ]);
    }

    /**
     * Handle user logout request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    /**
     * Get redirect route based on user role
     *
     * @param User $user
     * @return string
     */
    private function getRedirectRouteByRole(User $user)
    {
        if ($user->isAdmin()) {
            return route('admin.dashboard');
        } elseif ($user->isDosen()) {
            return route('dosen.dashboard');
        } else {
            return route('mahasiswa.dashboard');
        }
    }
}