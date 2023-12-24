<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:users|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        $username = $validatedData['username'];
        $email = $validatedData['email'];
        $password = $validatedData['password'];

        $userExists = User::where('username', $username)->exists();
        if ($userExists) {
            return response()->json(['message' => '帳號已存在'], 400);
        }
        $hashedPassword = Hash::make($password);

        $user = User::create([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
        ]);

        if ($user) {
            return response()->json(['message' => '註冊成功'], 200);
            // return redirect('/products')->with('success', '註冊成功');
        } else {
            return response()->json(['message' => '註冊失敗'], 500);
        }
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json(['message' => '登入成功', 'user' => $user]);
            // return Redirect::route('products.index'); 
        } else {
            return response()->json(['message' => '帳號或密碼錯誤'], 401);
        }
    }
}
