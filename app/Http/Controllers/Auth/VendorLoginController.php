<?php

namespace App\Http\Controllers\Auth;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.vendor-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $vendor = Vendor::where('email', $request->email)->first();

        if ($vendor && Hash::check($request->password, $vendor->password)) {
            Auth::guard('web')->login($vendor);
            return redirect()->intended('/vendor/dashboard');
        }

        return back()->withErrors(['email' => 'The provided credentials are incorrect.']);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }
}
