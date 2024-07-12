<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'nomor_telepon' => 'required|string|unique:users',
            'password' => 'required|string',
            'password_konfirmasi' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {

            $temporaryUser = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'nomor_telepon' => $request->nomor_telepon,
                'password' => bcrypt($request->password),
                'kode_otp' => null,
            ]);

            $token = Auth::guard('api')->login($temporaryUser);

            return response()->json([
                'success' => true,
                'message' => 'Akun berhasil dibuat, cek nomor telpon untuk verifikasi kode OTP nya ',
                'data' => [
                    'nomor_telepon' => $temporaryUser->nomor_telepon,
                    'is_verifikasi' => false,
                    'token' => $token,
                ],
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'internal server error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (!$token = Auth::guard('api')->attempt($validator->validated())) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'is_verifikasi' => true,
                'token' => $token,
            ],
        ], 200);
    }

    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out',
        ], 200);
    }
}
