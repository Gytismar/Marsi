<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthGRIController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/pagrindinis');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],

            'company_name' => ['required', 'string'],
            'company_code' => ['required', 'string', 'unique:companies,company_code'],
            'industry' => ['required', 'string'],
            'country' => ['required', 'string'],
            'size' => ['required', 'string'],
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->companies()->create([
            'company_name' => $validated['company_name'],
            'company_code' => $validated['company_code'],
            'industry' => $validated['industry'],
            'country' => $validated['country'],
            'size' => $validated['size'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/pagrindinis');
    }

}
