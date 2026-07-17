<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
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
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:8'
        ]);
        try {
             $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
              $user->sendEmailVerificationNotification();
            
            return redirect('/login')->with('success','Registration successful, Check your Email inbox, And Please verify your email.');;
        } catch (\Exception $e) {
            return redirect('/register')->with('error','Unable to register.');
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
            $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return back()->with('error','Wrong credentials');
        }
        if(!$user->hasVerifiedemail()){
            return back()->with('error','Please verify your email first');
        }
        Auth::login($user);
        $request->session()->regenerate();
        if($user->isAdmin()){
            return redirect('/dashboard');
        }
        return redirect('/product');
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
