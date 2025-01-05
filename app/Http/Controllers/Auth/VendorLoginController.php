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
      // Login the vendor using the 'vendors' guard
      Auth::guard('vendors')->login($vendor);
      return redirect()->intended('/vendor/dashboard');
    }

    return back()->withErrors(['email' => trans('auth.failed')]);
  }

  public function logout(Request $request)
  {
    Auth::guard('vendors')->logout();
    $request->session()->invalidate(); // Invalidate session
    $request->session()->regenerateToken(); // Regenerate CSRF token for security
    return redirect('/');
  }
}
