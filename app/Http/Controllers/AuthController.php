<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
         $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
         ]);

         $user = User::where('email', $request->email)->first();

         if ($user && Hash::check($request->password, $user->password)) {
             $request->session()->put('user', $user);
             return redirect()->route('dashboard.index');
         } else {
             return redirect()->back()->with('error', 'Email atau Password salah');
         }
    }

    public function dashboard(Request $request)
    {
         if (!$request->session()->has('user')) {
             return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu');
         }

         $user = $request->session()->get('user');

         return view('dashboard.index', compact('user'));
    }

    public function logout(Request $request)
    {
         $request->session()->flush();
         return redirect()->route('login');
    }

    public function showRegisterForm()
    {
         return view('auth.register');
    }

    public function register(Request $request)
    {
         $request->validate([
             'name'                  => 'required|string|max:255',
             'email'                 => 'required|email|unique:users,email',
             'password'              => 'required|min:6|confirmed',
             'role'                  => 'required|in:admin,petugas',
         ]);

         $user = User::create([
             'name'     => $request->name,
             'email'    => $request->email,
             'password' => Hash::make($request->password),
             'role'     => $request->role,
         ]);

         $request->session()->put('user', $user);
         return redirect()->route('dashboard.index');
 
        }

        
}
