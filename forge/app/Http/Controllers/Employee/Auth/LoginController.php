<?php

namespace App\Http\Controllers\Employee\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $guard = 'employee';

    protected $redirectTo = '/attendance';

    public function showLoginForm()
    {
        return view('employee.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::guard($this->guard)->attempt($credentials, $request->remember)) {
            return redirect()->intended($this->redirectTo);
        }

        return back()->withInput($request->only('username'))->withErrors([
            'username' => 'Invalid username or password',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard($this->guard)->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/employee/login');
    }
}
