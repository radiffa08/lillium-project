<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show() {
        return view('login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required']
            ]
        );
        $auth_validated = Auth::attempt($validated);

        if ($auth_validated) {
            $request->session()->regenerate();
            return redirect('/home');
        } else {
            return back()->withErrors([
                'error' => 'Invalid credentials.',
            ])->withInput();
        }
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
