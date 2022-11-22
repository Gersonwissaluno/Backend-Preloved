<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;

class ApiAuthenticationController extends Controller
{
    public function login()
    {
        $user = User::where('email', request('email'))->first();
        $credentials = ['email' => $user->email, 'password' => request('password')];
        if (!$token = JWTAuth::attempt($credentials)) {
            $status = 'ERR';
            $message = 'Password yang anda masukkan tidak valid';
            return response()->json(compact('status', 'message'), 401);
        } else {
            $status = 'OK';
            $message = 'Berhasil login';
            return response()->json(compact('status', 'message', 'user', 'token'), 200);
        }
    }

    public function register(Request $request)
    {
        $userCheck = User::where('email', request('email'))->first();
        if ($userCheck == null) {
            $user = User::create([
                'name' => $request->name,
                'jenis_kelamin' => $request->jenis_kelamin ?? '',
                'tanggal_lahir' => $request->tanggal_lahir ?? '',
                'alamat' => $request->alamat ?? '',
                'rt_rw' => $request->rt_rw ?? '',
                'nohp' => $request->nohp ?? '',
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $credentials = ['email' => $user->email, 'password' => request('password')];
            if ($token = JWTAuth::attempt($credentials)) {
                $status = 'OK';
                $message = 'Berhasil Register';
                return response()->json(compact('status', 'message', 'user', 'token'), 200);
            }
        } else {
            $status = 'ERR';
            $message = 'Gagal Register, User Terdaftar dengan email sama';
            return response()->json(compact('status', 'message'), 401);
        }
    }
}
