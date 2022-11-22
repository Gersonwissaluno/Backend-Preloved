<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register()
    {
        return view('register.index', [
            'title' => 'Register',
            'active' => 'register'
        ]);
    }
    public function store(Request $request)
    {
        $valid = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:5|max:20|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required'
        ]);

        $valid['password'] = bcrypt($valid['password']);


        User::create($valid);

        return redirect('/login')->with('success', 'Register anda berhasil! Silahkan login');
    }
}
