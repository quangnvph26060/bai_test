<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => "Sai tài khoản hoặc mật khẩu"
            ], 404);
        }

        $token = $user->createToken('authToken')->plainTextToken;
        session(['token' => $token]);

        // Kiểm tra token mới với token trong lưu trữ
        if ($token === session('token')) {
            // Cấp quyền đăng nhập
            auth()->login($user);

            // Lấy thông tin người dùng đã đăng nhập
            $authenticatedUser = auth()->user();

            // Tiến hành các thao tác sau khi cấp quyền đăng nhập thành công
            // Ví dụ: Lấy thông tin người dùng và trả về phản hồi JSON
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $authenticatedUser
            ], 200);
        } else {
            return response()->json([
                'message' => "Token không khớp"
            ], 401);
        }
    }


    public function register(Request $request)
    {
        $messages = [
            'email.email' => 'error email'
        ];
        $validate = Validator::make($request->all(), [
            'email' => 'email',
            'password' => 'required'
        ], $messages);
        if ($validate->fails()) {
            return response()->json(
                [
                    'message' => $validate->errors()
                ],
                404
            );
        }


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return response()->json(
            [
                'message' => 'created'
            ],
            200
        );
    }
}
