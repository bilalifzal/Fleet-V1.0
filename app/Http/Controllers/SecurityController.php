<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
    // Show the visual login screen
    public function showGateway()
    {
        return view('auth.gateway'); 
    }

    // The Multi-Step Validation Logic
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
            'cnic'     => ['required', 'string'],
            'pin_code' => ['required', 'string'],
        ]);

        if (Auth::attempt([
            'email'    => $credentials['email'],
            'password' => $credentials['password'],
            'cnic'     => $credentials['cnic'],
            'pin_code' => $credentials['pin_code'],
        ])) {
            $request->session()->regenerate();
            return redirect()->intended('/command-center');
        }

        return back()->withErrors([
            'email' => 'Access Denied. Invalid credentials or PIN.',
        ]);
    }
}
