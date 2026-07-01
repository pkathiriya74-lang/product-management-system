<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showRegister()
    {
        if (Auth::check()) {
            return back()->with('error', 'First logout');
        }
        return view("auths.register");
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return back()->with('error', 'First logout');
        }
        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:8'
        ]);
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            return redirect('/login');
        } catch (\Exception $e) {
            return redirect('/register')->with('error', 'Unable to register');
        }

    }

    public function showLogin()
    {
        if (Auth::check()) {
            return back()->with('error', 'First logout');
        }
        return view('auths.login');
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return back()->with('error', 'First logout');
        }
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt($credential)) {
            $request->session()->regenerate();
            return redirect('/dashboard');
        } else {
            return redirect('/login')->with('error', 'Wrong Credentials');
        }

    }

    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
        if (!Auth::check()) {
            return redirect('/login');
        }
    }

}
