<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = auth()->user();
            
            if ($user->isAdmin()) {
                if ($user->status !== 'active') {
                    Auth::logout();
                    return back()->withErrors(['email' => 'Your account is inactive. Please contact support.'])->withInput();
                }
                
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }
            
            Auth::logout();
            return back()->withErrors(['email' => 'Access denied. Authorized personnel only.'])->withInput();
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}